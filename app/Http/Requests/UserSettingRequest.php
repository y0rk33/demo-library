<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = Auth::user();

        return [
            'email' => 'required|email|unique:users,email,'.$user->id.',id,deleted_at,NULL',
            'new_password' => 'min:6',
            'new_password_confirmation' => 'min:6|same:new_password'
        ];
    }
}
