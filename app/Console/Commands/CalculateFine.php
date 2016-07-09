<?php

namespace App\Console\Commands;

use App\BorrowTransaction;
use App\Fine;
use App\Parameter;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateFine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate_fine';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To calculate all late return fines';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get the fine from params table
        $fine_per_date = Parameter::where('name', 'fine')->first()->value;

        // get the transactions with the date of return yesterday and earlier
        $today = Carbon::now();
        $yesterday = Carbon::yesterday();
        $transactions = BorrowTransaction::where('status', 'On Loan')
            ->whereDate('to_be_returned_at', '<=', $yesterday)
            ->get();

        // calculate the days difference between today and the date of return and multiple by the fine
        foreach($transactions as $transaction) {
            $difference = $today->diffInDays($transaction->to_be_returned_at);
            $update_amount = $difference * $fine_per_date;

            // if doesn't have have fine - insert, else - update
            if (empty($transaction->fine)) {
                $fine = new Fine();
                $fine->transaction_id = $transaction->id;
                $fine->amount = $update_amount;
                $fine->status = 'Not Payed';
                $fine->save();
            } else {
                $fine = $transaction->fine;
                $fine->amount = $update_amount;
                $fine->status = 'Not Payed';
                $fine->save();
            }
        }

    }
}
