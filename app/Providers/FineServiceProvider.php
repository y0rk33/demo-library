<?php

namespace App\Providers;

use App\Fine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class FineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Fine::creating(function($fine) {
            $fine->created_by = Auth::user()->id;
            $fine->updated_by = Auth::user()->id;
        });

        Fine::updating(function($fine) {
            $fine->updated_by = Auth::user()->id;
        });

        Fine::deleting(function($fine) {
            $fine->updated_by = Auth::user()->id;
            $fine->save();
        });

//        Fine::restoring(function($fine) {
//            $fine->updated_by = Auth::user()->id;
//            $fine->save();
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
