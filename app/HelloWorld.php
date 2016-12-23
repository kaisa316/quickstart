<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelloWorld extends Model
{
    use SoftDeletes;
	protected $table = 'helloworld';
	//protected $fillable = ['title'];//mass assign
	protected $dates = ['deleted_at'];

	protected static function boot() {
		parent::boot();
		//global scope
		/*
		static::addGlobalScope(function(Builder $builder) {
			$builder->where('title','内蒙');	
		});
		*/

	}


	public function scopeTitle($builder,$title_val) {
		return $builder->where('title',$title_val);
	}
}
