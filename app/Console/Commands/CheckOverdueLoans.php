<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;

class CheckOverdueLoans extends Command
{
    protected $signature = 'loans:check-overdue';
    protected $description = 'Mark overdue loans and calculate fines';

    public function handle()
    {
        $overdue = Loan::where('status','borrowed')->where('due_at','<', now())->get();
        foreach($overdue as $loan){
            $loan->update(['status' => 'overdue']);
            $days = now()->diffInDays($loan->due_at);
            $loan->update(['fine_amount' => $days * 1]);
        }
        $this->info('Checked overdue loans: ' . $overdue->count());
    }
}
