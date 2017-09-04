<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeDirection extends Model
{
	protected $fillable = ['description'];

	public function recipe()
	{
		return $this->belongsTo(Recipe::class);
	}

	public static function form()
	{
		return [
			'description' => ''
		];
	}
}
