document.addEventListener("DOMContentLoaded", () => {
    // CSRF token
    const token = document.head.querySelector(
        'meta[name="csrf-token"]'
    ).content;
    let selectedBookId = null;

    // Open borrow modal
    document.querySelectorAll(".borrow-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            selectedBookId = btn.dataset.bookId;
            document.getElementById("borrowModal").classList.remove("hidden");
        });
    });

    // Close modal
    const closeModalBtn = document.getElementById("closeModal");
    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", () => {
            document.getElementById("borrowModal").classList.add("hidden");
        });
    }

    // Pay instantly
    const payInstantBtn = document.getElementById("payInstantBtn");
    if (payInstantBtn) {
        payInstantBtn.addEventListener("click", async () => {
            if (!selectedBookId) return;
            try {
                const res = await fetch(`/books/${selectedBookId}/borrow`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({ payment_option: "instant" }),
                });
                const json = await res.json();
                if (json.checkoutUrl) {
                    window.location.href = json.checkoutUrl;
                } else if (json.message) {
                    alert(json.message);
                }
            } catch (err) {
                console.error(err);
                alert("Something went wrong. Try again.");
            }
        });
    }

    // Pay deferred
    const payDeferredBtn = document.getElementById("payDeferredBtn");
    if (payDeferredBtn) {
        payDeferredBtn.addEventListener("click", async () => {
            if (!selectedBookId) return;
            try {
                const res = await fetch(`/books/${selectedBookId}/borrow`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({ payment_option: "deferred" }),
                });
                const json = await res.json();
                if (json.message) {
                    alert(json.message);
                    document
                        .getElementById("borrowModal")
                        .classList.add("hidden");
                    location.reload();
                }
            } catch (err) {
                console.error(err);
                alert("Something went wrong. Try again.");
            }
        });
    }
});
