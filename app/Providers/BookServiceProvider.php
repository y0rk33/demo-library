<?php

namespace App\Providers;

use App\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class BookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Book::creating(function($book) {
            // this check is just to run the db:seed
            if (empty(Auth::user())) {
                $book->created_by = '1';
                $book->updated_by = '1';
            } else {
                $book->created_by = Auth::user()->id;
                $book->updated_by = Auth::user()->id;
            }

        });

        Book::updating(function($book) {
            if (empty(Auth::user())) {
                $book->updated_by = '1';
            } else {
                $book->updated_by = Auth::user()->id;
            }
        });

        Book::deleting(function($book) {
            $book->updated_by = Auth::user()->id;
            $book->save();
        });

//        Book::restoring(function($book) {
//            $book->updated_by = Auth::user()->id;
//            $book->save();
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
