<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        User::creating(function($user) {
            if (empty(Auth::user())) {
                $user->created_by = '1';
                $user->updated_by = '1';
            } else {
                $user->created_by = Auth::user()->id;
                $user->updated_by = Auth::user()->id;
            }
        });

        User::updating(function($user) {
            if (empty(Auth::user())) {
                $user->updated_by = '1';
            } else {
                $user->updated_by = Auth::user()->id;
            }
        });

        User::deleting(function($user) {
            $user->updated_by = Auth::user()->id;
            $user->save();
        });

//        User::restoring(function($user) {
//            $user->updated_by = Auth::user()->id;
//            $user->save();
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
