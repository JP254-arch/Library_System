@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6">
        <h1 class="text-3xl font-bold mb-6">💰 Finance</h1>
        <p class="text-gray-600 mb-8">All payments made in the library.</p>

        <div class="mb-6">
            <span class="text-lg font-semibold">Total Revenue:</span>
            <span class="text-green-600 font-bold">{{ number_format($totalRevenue, 2) }} Ksh</span>
        </div>

        {{-- FILTER FORM --}}
        <form method="GET" class="mb-6 bg-white p-4 rounded-lg shadow flex flex-wrap gap-4">

            <input type="text" name="user_name" placeholder="Search by User" value="{{ request('user_name') }}"
                class="border rounded px-3 py-2 w-48">

            <input type="text" name="book" placeholder="Search by Book" value="{{ request('book') }}"
                class="border rounded px-3 py-2 w-48">

            <select name="method" class="border rounded px-3 py-2 w-44">
                <option value="">All Methods</option>
                <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="mpesa" {{ request('method') == 'mpesa' ? 'selected' : '' }}>Mpesa</option>
                <option value="stripe" {{ request('method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
            </select>

            <input type="date" name="from_date" value="{{ request('from_date') }}" class="border rounded px-3 py-2">

            <input type="date" name="to_date" value="{{ request('to_date') }}" class="border rounded px-3 py-2">

            <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded">
                Filter
            </button>

            <a href="{{ url()->current() }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                Reset
            </a>

        </form>

        {{-- PAYMENT TABLE --}}
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">User</th>
                            <th class="px-6 py-3 text-left">Book</th>
                            <th class="px-6 py-3 text-left">Borrow Fee</th>
                            <th class="px-6 py-3 text-left">Fine</th>
                            <th class="px-6 py-3 text-left">Total Paid</th>
                            <th class="px-6 py-3 text-left">Payment Method</th>
                            <th class="px-6 py-3 text-left">Reference</th>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Receipt</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $payment->user->name ?? 'N/A' }}</td>

                                <td class="px-6 py-4">
                                    {{ $payment->loan->book->title ?? 'Unknown' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ number_format($payment->borrow_fee, 2) }}
                                </td>

                                <td class="px-6 py-4 text-red-600">
                                    {{ number_format($payment->fine_total, 2) }}
                                </td>

                                <td class="px-6 py-4 font-semibold">
                                    {{ number_format($payment->total, 2) }}
                                </td>

                                <td class="px-6 py-4">{{ $payment->method }}</td>
                                <td class="px-6 py-4">{{ $payment->reference }}</td>

                                <td class="px-6 py-4">
                                    {{ $payment->created_at->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    <a href="{{ route('receipt.download', $payment->id) }}"
                                        class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm">
                                        PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                                    No payment records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
