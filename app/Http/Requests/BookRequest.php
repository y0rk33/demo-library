<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BookRequest extends Request
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
            //isbn can be with or without dashese
            'isbn' => 'required|regex:/^[0-9 .\-]+$/i|unique:books,isbn,'.$this->book.',id,deleted_at,NULL|min:10|max:17',
            'title' => 'required',
            'year' => 'required',
            'author' => 'required',
            'total_qty' => 'required|numeric|min:0',
            'shelf_location' => 'required',
            'book_cover' => 'max:100|mimes:jpg,png,jpeg'
        ];
    }
}
