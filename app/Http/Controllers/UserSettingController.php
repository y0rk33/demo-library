<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSettingController extends Controller
{
    public function index() {

		Log::info('User '.Auth::user()->doc_id.' user_settings -> index');
		return view('my_profile.settings');
	}

	public function edit() {
		$user = Auth::user();

		Log::info('User '.Auth::user()->doc_id.' user_settings -> edit');
		return view('my_profile.edit', compact('user'));
	}

	public function update(Requests\UserSettingRequest $request) {

		if (Hash::check($request->current_password, Auth::user()->password)) {
			Auth::user()->update($request->all());

			// new password and current password are not the same
			if (!empty($request->new_password)) {
				if (! Hash::check($request->new_password, Auth::user()->password)) {
					Auth::user()->password = Hash::make($request->new_password);
					Auth::user()->save();

					flash()->success('Changes have been successfully saved');
					Log::info('User '.Auth::user()->doc_id.' user_settings -> update : success');
				} else {
					flash()->error('New & Current Passwords cannot be the same');
					Log::info('User '.Auth::user()->doc_id.' user_settings -> update : new and current password are the same');
				}
			}

		} else {
			flash()->error('Password is incorrect');
			Log::info('User '.Auth::user()->doc_id.' user_settings -> update : incorrect password');
		}

		return redirect('my_profile/edit');
	}
}
