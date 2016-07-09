<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
        return [
            'doc_id' => 'required|unique:users,doc_id,'.$this->member.',id,deleted_at,NULL',
            'email' => 'required|email|unique:users,email,'.$this->member.',id,deleted_at,NULL',
            'first_name' => 'required',
            'date_of_birth' => 'required|date',
        ];
    }
}
