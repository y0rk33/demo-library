<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowTransaction extends Model
{
	protected $dates = ['borrowed_at', 'returned_at', 'to_be_returned_at'];

	protected $fillable = [
		'user_id',
		'book_id',
		'borrowed_at',
		'return_at',
		'status',
	];

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function book() {
		return $this->belongsTo('App\Book');
	}

	public function fine() {
		return $this->hasOne('App\Fine', 'transaction_id');
	}
}
