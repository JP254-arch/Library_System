@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-4">
    <h1 class="text-2xl font-bold mb-6">
        Welcome back, {{ auth()->user()->name }} 👋
    </h1>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">📚 Your Borrowed Books</h2>

        @if($loans->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
                    <thead class="bg-gray-100 text-gray-700 uppercase">
                        <tr>
                            <th class="py-3 px-4 text-left">Book Title</th>
                            <th class="py-3 px-4 text-left">Borrowed On</th>
                            <th class="py-3 px-4 text-left">Due Date</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Fine (Ksh)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-4 font-medium text-gray-800">
                                    {{ $loan->book->title ?? 'Unknown Book' }}
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ $loan->borrowed_at ? $loan->borrowed_at->format('M d, Y') : '-' }}
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ $loan->due_at ? $loan->due_at->format('M d, Y') : '-' }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($loan->status === 'returned')
                                        <span class="text-green-600 font-semibold">Returned</span>
                                    @elseif(now()->gt($loan->due_at))
                                        <span class="text-red-600 font-semibold">Overdue</span>
                                    @else
                                        <span class="text-yellow-600 font-semibold">Borrowed</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($loan->fine_amount > 0)
                                        <span class="text-red-600 font-semibold">{{ number_format($loan->fine_amount, 2) }}</span>
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-10 text-gray-600">
                <p>You haven’t borrowed any books yet.</p>
                <a href="{{ route('home') }}"
                   class="inline-block mt-4 px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Browse Books
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
