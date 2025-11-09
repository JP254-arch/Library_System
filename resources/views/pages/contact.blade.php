@extends('layouts.app')

@section('content')
    <section class="min-h-screen bg-gray-50 flex items-center py-16 px-4">
        <div class="container mx-auto max-w-6xl">

            <!-- Title -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h1 class="text-4xl md:text-5xl font-extrabold text-rose-600 mb-4">
                    📚 Contact <span class="text-indigo-700">Lexicon</span>
                </h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Have a question, suggestion, or just want to say hi?
                    We’d love to hear from you — your words are as valuable as our books!
                </p>
            </div>

            <!-- Layout -->
            <div class="flex flex-col lg:flex-row gap-10 items-stretch">

                {{-- Left: Contact Form --}}
                <div class="lg:w-1/2 bg-white rounded-2xl shadow-2xl border border-gray-100 p-8" data-aos="fade-up">
                    <h2 class="text-2xl font-semibold text-rose-700 mb-6 text-center">
                        Send Us a Message
                    </h2>
                    <form id="contactForm" action="https://formspree.io/f/mkgkwvdj" method="POST" class="space-y-6">
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-2">Your Name</label>
                            <input type="text" name="name" id="name" placeholder="e.g. Jp Mbaga"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-500 transition"
                                required>
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                            <input type="email" name="email" id="email" placeholder="e.g. jp@lexicon.com"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-500 transition"
                                required>
                        </div>

                        <div>
                            <label for="message" class="block text-gray-700 font-medium mb-2">Your Message</label>
                            <textarea name="message" id="message" rows="5" placeholder="Type your message here..."
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-500 transition"
                                required></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition-all duration-200">
                            ✉️ Send Message
                        </button>
                    </form>

                    {{-- Success / Error Messages --}}
                    <div id="formMessage"
                        class="mt-6 text-center text-white font-semibold px-4 py-3 rounded-lg opacity-0 transform translate-y-4 transition-all duration-700">
                    </div>
                </div>

                {{-- Right: Contact Info --}}
                <div class="lg:w-1/2 flex flex-col justify-center bg-gradient-to-br from-indigo-50 to-rose-50 p-10 rounded-2xl shadow-inner border border-gray-100"
                    data-aos="fade-up" data-aos-delay="100">
                    <h2 class="text-2xl font-semibold text-indigo-700 mb-6">Or Reach Us Directly</h2>

                    <div class="space-y-4 text-gray-700">
                        <p><span class="font-medium text-rose-600">📧 Email:</span>
                            <a href="mailto:info@lexicon.com" class="text-indigo-600 hover:underline">info@lexicon.com</a> |
                            <a href="mailto:helpline@lexicon.com"
                                class="text-indigo-600 hover:underline">helpline@lexicon.com</a>
                        </p>
                        <p><span class="font-medium text-rose-600">📞 Phone:</span>
                            <a href="tel:+1234567890" class="text-indigo-600 hover:underline">+1 (234) 567-890</a>
                        </p>
                        <p><span class="font-medium text-rose-600">📌 Address:</span>
                            123 Lexicon Library St, Knowledge City
                        </p>
                    </div>

                    <div class="mt-8 text-gray-500 text-sm italic border-t border-gray-200 pt-4">
                        “Lexicon Library — where curiosity meets knowledge, and every book has a story to tell.”
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Form Animation Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            const formMessage = document.getElementById('formMessage');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const data = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: data,
                    headers: {
                        'Accept': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        showMessage('✅ Message sent successfully!', 'bg-green-500');
                        form.reset();
                    } else {
                        response.json().then(data => {
                            showMessage(data?.errors?.map(err => err.message).join(', ') ||
                                '❌ Oops! Something went wrong.', 'bg-red-500');
                        });
                    }
                }).catch(() => {
                    showMessage('❌ Oops! Something went wrong.', 'bg-red-500');
                });

                function showMessage(msg, bgClass) {
                    formMessage.textContent = msg;
                    formMessage.className =
                        `mt-6 text-center text-white font-semibold px-4 py-3 rounded-lg ${bgClass} opacity-100 transform translate-y-0 transition-all duration-700`;
                    setTimeout(() => {
                        formMessage.className =
                            `mt-6 text-center text-white font-semibold px-4 py-3 rounded-lg ${bgClass} opacity-0 transform translate-y-4 transition-all duration-700`;
                    }, 4000);
                }
            });
        });
    </script>
@endsection
