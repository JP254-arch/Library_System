@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h1 class="text-3xl font-bold mb-6">👑 Admin Dashboard</h1>
    <p class="text-gray-600 mb-8">
        Welcome back, {{ auth()->user()->name }}. Here’s what’s happening in your library today.
    </p>

    {{-- Dashboard Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        {{-- Books --}}
        <div class="bg-indigo-50 border-l-4 border-indigo-500 rounded-lg p-5 shadow-sm hover:shadow-md transition cursor-pointer">
            <h2 class="text-sm font-semibold text-indigo-700 uppercase">Books</h2>
            <p class="text-3xl font-bold text-indigo-800 mt-2">{{ \App\Models\Book::count() }}</p>
            <div class="mt-3 space-x-2">
                <a href="{{ route('books.index') }}"
                   class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                   Manage Books
                </a>
                <a href="{{ route('books.create') }}"
                   class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                   ➕ Add Book
                </a>
            </div>
        </div>

        {{-- Users --}}
        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-5 shadow-sm hover:shadow-md transition cursor-pointer">
            <h2 class="text-sm font-semibold text-green-700 uppercase">Users</h2>
            <p class="text-3xl font-bold text-green-800 mt-2">{{ \App\Models\User::count() }}</p>
            <a href="{{ route('users.manage') }}"
               class="mt-3 inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
               Manage Users
            </a>
        </div>

        {{-- Authors --}}
        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-5 shadow-sm hover:shadow-md transition cursor-pointer">
            <h2 class="text-sm font-semibold text-yellow-700 uppercase">Authors</h2>
            <p class="text-3xl font-bold text-yellow-800 mt-2">{{ \App\Models\Author::count() }}</p>
            <a href="{{ route('authors.index') }}"
               class="mt-3 inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
               Manage Authors
            </a>
        </div>

        {{-- Loans --}}
        <div class="bg-pink-50 border-l-4 border-pink-500 rounded-lg p-5 shadow-sm hover:shadow-md transition cursor-pointer">
            <h2 class="text-sm font-semibold text-pink-700 uppercase">Active Loans</h2>
            <p class="text-3xl font-bold text-pink-800 mt-2">{{ \App\Models\Loan::where('status', 'borrowed')->count() }}</p>
            <a href="{{ route('loans.index') }}"
               class="mt-3 inline-block bg-pink-600 hover:bg-pink-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
               Manage Loans
            </a>
        </div>
    </div>

    {{-- Recent Loans --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">📘 Recent Loans</h2>

        @php
            $recentLoans = \App\Models\Loan::with(['book', 'user'])
                            ->latest()
                            ->take(5)
                            ->get();
        @endphp

        @if($recentLoans->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase">
                        <tr>
                            <th class="py-3 px-4 text-left">Book</th>
                            <th class="py-3 px-4 text-left">Borrower</th>
                            <th class="py-3 px-4 text-left">Borrowed On</th>
                            <th class="py-3 px-4 text-left">Due Date</th>
                            <th class="py-3 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentLoans as $loan)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $loan->book->title ?? 'Unknown' }}</td>
                                <td class="py-3 px-4">{{ $loan->user->name ?? 'N/A' }}</td>
                                <td class="py-3 px-4">{{ $loan->borrowed_at?->format('M d, Y') ?? '-' }}</td>
                                <td class="py-3 px-4">{{ $loan->due_at?->format('M d, Y') ?? '-' }}</td>
                                <td class="py-3 px-4">
                                    @if($loan->status === 'returned')
                                        <span class="text-green-600 font-semibold">Returned</span>
                                    @elseif(now()->gt($loan->due_at))
                                        <span class="text-red-600 font-semibold">Overdue</span>
                                    @else
                                        <span class="text-yellow-600 font-semibold">Borrowed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">No recent loans available.</p>
        @endif
    </div>
</div>
@endsection
