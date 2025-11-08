<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:librarian|admin')->only(['index', 'returnLoan', 'destroy']);
        $this->middleware('role:member')->only(['borrow', 'returnBook', 'myLoans']);
    }

    // Admin / Librarian - Manage Loans Page
    public function index()
    {
        $loans = Loan::with(['book', 'user'])->latest()->paginate(20);
        return view('loans.index', compact('loans'));
    }

    // Member - Borrow a book
    public function borrow(Book $book)
    {
        if ($book->available_copies < 1) {
            return back()->with('error', 'No copies available.');
        }

        $due_at = now()->addWeeks(2);

        DB::transaction(function () use ($book, $due_at) {
            Loan::create([
                'book_id' => $book->id,
                'user_id' => auth()->id(),
                'borrowed_at' => now(),
                'due_at' => $due_at,
                'status' => 'borrowed',
            ]);

            $book->decrement('available_copies');
        });

        return back()->with('success', 'Book borrowed successfully.');
    }

    // Member - Return a book
    public function returnBook(Book $book)
    {
        $loan = auth()->user()->loans()
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->first();

        if (!$loan) {
            return back()->with('error', 'No active loan found for this book.');
        }

        DB::transaction(function () use ($loan, $book) {
            $loan->update([
                'returned_at' => now(),
                'status' => 'returned',
            ]);

            $book->increment('available_copies');
        });

        return back()->with('success', 'Book returned successfully.');
    }

    // Member - View own loans
    public function myLoans()
    {
        $loans = auth()->user()->loans()->with(['book.author', 'book.category'])->latest()->get();
        return view('users.dashboard', ['user' => auth()->user(), 'loans' => $loans]);
    }

    // Admin / Librarian - Mark loan as returned
    public function returnLoan(Loan $loan)
    {
        if ($loan->status === 'returned') {
            return back()->with('error', 'This loan has already been returned.');
        }

        DB::transaction(function () use ($loan) {
            $loan->update([
                'returned_at' => now(),
                'status' => 'returned',
            ]);

            $loan->book->increment('available_copies');
        });

        return back()->with('success', 'Loan marked as returned.');
    }

    // Admin / Librarian - Delete a loan
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return back()->with('success', 'Loan deleted successfully.');
    }
}
