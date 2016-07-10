<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
	protected $fillable =[
		'transaction_id',
		'amount',
		'status'
	];
}
