@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-indigo-600 mb-6 text-center">My Loans</h1>

        @if ($loans->isEmpty())
            <p class="text-gray-500 text-center">You have no borrowed books.</p>
        @else
            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($loans as $loan)
                    <div class="bg-white shadow-md rounded-2xl overflow-hidden flex flex-col">
                        <img src="{{ $loan->book->cover ? asset('storage/' . ltrim($loan->book->cover['path'], '/')) : asset('images/default-cover.jpg') }}"
                            alt="{{ $loan->book->title }}"
                            class="w-full h-48 object-cover {{ $loan->book->cover ? '' : 'opacity-70' }}">
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="text-xl font-semibold mb-2">{{ $loan->book->title }}</h4>
                                <p class="text-gray-600 mb-2">by {{ $loan->book->author->name ?? 'Unknown' }}</p>
                                <p class="text-gray-500 mb-2">Status:
                                    @if ($loan->status === 'borrowed')
                                        <span class="text-yellow-600 font-semibold">Borrowed</span>
                                    @else
                                        <span class="text-green-600 font-semibold">Returned</span>
                                    @endif
                                </p>
                                <p class="text-gray-500 mb-4">Payment:
                                    @if ($loan->payment_status === 'paid')
                                        <span class="text-green-600 font-semibold">Paid</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Unpaid</span>
                                    @endif
                                </p>
                            </div>

                            <div class="flex flex-col space-y-2">
                                @if ($loan->payment_status === 'unpaid')
                                    <form method="POST" action="{{ route('loans.payDeferred', $loan->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg">
                                            Pay Now
                                        </button>
                                    </form>
                                @endif

                                @if ($loan->status === 'borrowed')
                                    <button data-loan-id="{{ $loan->id }}"
                                        class="return-btn w-full bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded-lg">
                                        Return Book
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $loans->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const token = document.head.querySelector('meta[name="csrf-token"]').content;

                document.querySelectorAll('.return-btn').forEach(btn => {
                    btn.addEventListener('click', async () => {
                        const loanId = btn.dataset.loanId;
                        if (!loanId) return;

                        try {
                            const res = await fetch(`/books/${loanId}/return`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': token,
                                    'Accept': 'application/json'
                                }
                            });
                            const json = await res.json();
                            if (json.message) {
                                alert(json.message);
                                location.reload();
                            }
                        } catch (err) {
                            console.error(err);
                            alert('Something went wrong.');
                        }
                    });
                });
            });
        </script>
    @endpush

@endsection
