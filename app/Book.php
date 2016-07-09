<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
	use SoftDeletes;

	protected $fillable =[
		'isbn',
		'title',
		'edition',
		'year',
		'author',
		'shelf_location',
		'description',
		'total_qty',
	];

	public function transactions() {
		return $this->hasMany('App\BorrowTransaction');

	}
}
