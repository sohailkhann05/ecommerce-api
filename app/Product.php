<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
		'name',
		'description',
		'stock',
		'price',
		'discount'
	];

	public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
    	return $this->hasMany(Review::class);
    }
}
