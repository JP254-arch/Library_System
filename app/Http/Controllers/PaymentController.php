<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Create Stripe Checkout session for a loan
     */
    public function checkout(Request $request, Loan $loan)
    {
        if ($loan->is_paid) {
            return back()->with('info', 'This loan has already been paid.');
        }

        // Calculate fees for Stripe
        $borrowFee = 70;
        $finePerDay = 20;

        $fineDays = $loan->late_days ?? (
            now()->greaterThan($loan->due_at)
            ? Carbon::parse($loan->due_at)->diffInDays(now())
            : 0
        );

        $fineTotal = $fineDays * $finePerDay;
        $total = $borrowFee + $fineTotal;

        // Stripe requires USD; convert KES → USD (simple)
        $usdAmount = max(1, round($total / 155)); // prevent 0 USD errors

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Borrow Fee - ' . $loan->book->title,
                        ],
                        'unit_amount' => $usdAmount * 100, // cents
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['loan' => $loan->id]),
            'cancel_url' => route('payment.cancel', ['loan' => $loan->id]),
        ]);

        return redirect($session->url);
    }

    /**
     * Handle successful Stripe payment
     */
    public function success(Loan $loan)
    {
        // Mark loan as paid
        $loan->update([
            'is_paid' => true,
            'status' => 'borrowed',
        ]);

        // Final fee calculations
        $borrowFee = 70;
        $finePerDay = 20;

        $fineDays = $loan->late_days ?? (
            now()->greaterThan($loan->due_at)
            ? Carbon::parse($loan->due_at)->diffInDays(now())
            : 0
        );

        $fineTotal = $fineDays * $finePerDay;

        // Save payment
        $payment = Payment::create([
            'user_id' => $loan->user_id,
            'loan_id' => $loan->id,
            'method' => 'Stripe',
            'reference' => 'STRIPE-' . strtoupper(uniqid()),
            'borrow_fee' => $borrowFee,
            'fine_per_day' => $finePerDay,
            'fine_days' => $fineDays,
            'fine_total' => $fineTotal,
            'total' => $borrowFee + $fineTotal,
        ]);

        return view('payments.checkout', [
            'loan' => $loan,
            'status' => 'success',
            'message' => 'Payment successful!',
            'payment' => $payment,
        ]);
    }

    /**
     * Handle canceled Stripe payment
     */
    public function cancel(Loan $loan)
    {
        return view('payments.checkout', [
            'loan' => $loan,
            'status' => 'cancelled',
            'message' => 'Payment cancelled. You can try again later.',
        ]);
    }

    /**
     * Download PDF receipt for a payment
     */
    public function downloadReceipt(Payment $payment)
    {
        $payment->load('loan.book', 'user');

        $pdf = Pdf::loadView('pdf.receipt', compact('payment'));

        return $pdf->download('Receipt_' . $payment->id . '.pdf');
    }

    /**
     * Display finance page with filters
     */
    public function finance(Request $request)
    {
        $query = Payment::with(['user', 'loan.book']);

        if ($request->user_name) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->user_name . '%'));
        }

        if ($request->book) {
            $query->whereHas('loan.book', fn($q) => $q->where('title', 'like', '%' . $request->book . '%'));
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $payments = $query->latest()->get();
        $totalRevenue = $payments->sum('total');

        return view('admin.finance.index', compact('payments', 'totalRevenue'));
    }
}
