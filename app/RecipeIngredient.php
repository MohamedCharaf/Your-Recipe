<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
	protected $fillable = [
		'name', 'qty'
	];

	public function recipe()
	{
		return $this->belongsTo(Recipe::class);
	}

	public static function form()
	{
		return [
			'name' => '',
			'qty' => ''
		];
	}

}
