<?php

namespace App\Console\Commands;

use App\BorrowTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CancelRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel_request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To cancel all the pending requests';

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
        $transactions = BorrowTransaction::where('status', 'Requested')->get();

        foreach($transactions as $transaction) {
            DB::transaction(function($transaction) use ($transaction) {
                $transaction->status = 'Cancelled';
                $transaction->save();

                $book = $transaction->book;
                $book->current_qty += 1;
                $book->save();
            });

        }
    }
}
