<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
    	'name',
	'price',
	'image'
    ];

    public function comments() 
    {
    	return $this->hasMany('App\Models\Comment');
    }

    public function wishlist() 
    {
    	return $this->belongsToMany('App\Models\User', 'wishlist');
    }

    public function purchases() 
    {
    	return $this->belongsToMany('App\Models\User', 'purchases');
    }
}
