@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Manage Loans</h2>

    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($loans as $loan)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loan->book->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loan->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loan->loan_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loan->return_date ? $loan->return_date->format('d M Y') : '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-lg">
                                Return
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($loans->isEmpty())
            <div class="text-center py-6 text-gray-500">No loans found.</div>
        @endif
    </div>
</div>
@endsection
