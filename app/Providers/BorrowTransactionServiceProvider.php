<?php

namespace App\Providers;

use App\BorrowTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class BorrowTransactionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        BorrowTransaction::creating(function($borrow_transaction) {
            $borrow_transaction->created_by = Auth::user()->id;
            $borrow_transaction->updated_by = Auth::user()->id;
        });

        BorrowTransaction::updating(function($borrow_transaction) {
            $borrow_transaction->updated_by = Auth::user()->id;
        });

        BorrowTransaction::deleting(function($borrow_transaction) {
            $borrow_transaction->updated_by = Auth::user()->id;
            $borrow_transaction->save();
        });

//        BorrowTransaction::restoring(function($borrow_transaction) {
//            $borrow_transaction->updated_by = Auth::user()->id;
//            $borrow_transaction->save();
//        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
