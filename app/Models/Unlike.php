<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unlike extends Model
{
	protected $table = 'unlikeable';

	public function unlikeable()
	{
		return $this->morphTo();
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}