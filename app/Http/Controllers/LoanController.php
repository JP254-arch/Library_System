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
        $this->middleware('role:librarian|admin')->only(['index', 'markReturned']);
        $this->middleware('role:member')->only(['borrow', 'myLoans']);
    }

    /**
     * Display all loans (Admin/Librarian only)
     */
    public function index()
    {
        $loans = Loan::with(['book', 'user'])
            ->latest()
            ->paginate(20);

        return view('loans.index', compact('loans'));
    }

    /**
     * Borrow a book (Member only)
     */
    public function borrow(Request $request, Book $book)
    {
        if ($book->available_copies < 1) {
            return back()->with('error', 'No copies available for borrowing.');
        }

        $due_at = now()->addWeeks(2);

        DB::transaction(function () use ($book, $due_at) {
            Loan::create([
                'book_id'    => $book->id,
                'user_id'    => auth()->id(),
                'borrowed_at'=> now(),
                'due_at'     => $due_at,
                'status'     => 'borrowed',
            ]);

            $book->decrement('available_copies');
        });

        return redirect()
            ->route('loans.my')
            ->with('success', 'Book borrowed successfully.');
    }

    /**
     * Mark a loan as returned (Admin/Librarian only)
     */
    public function markReturned(Loan $loan)
    {
        if ($loan->returned_at) {
            return back()->with('info', 'This book has already been returned.');
        }

        DB::transaction(function () use ($loan) {
            $loan->update([
                'returned_at' => now(),
                'status'      => 'returned',
            ]);

            $loan->book->increment('available_copies');

            // Apply fine if overdue
            if (now()->gt($loan->due_at)) {
                $daysLate = now()->diffInDays($loan->due_at);
                $loan->update(['fine_amount' => $daysLate * 1.00]);
            }
        });

        return back()->with('success', 'Book returned successfully.');
    }

    /**
     * Display the logged-in user's borrowed books (Member only)
     */
    public function myLoans()
    {
        $loans = auth()->user()
            ->loans()
            ->with(['book.author', 'book.category'])
            ->latest()
            ->get();

        return view('users.dashboard', [
            'user' => auth()->user(),
            'loans' => $loans,
        ]);
    }
}
