<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
    	'title',
	'content'
    ];

    public function user() 
    {
    	return $this->belongsTo('App\Models\User');
    }

    public function article()
    {
    	return $this->belongsTo('App\Models\Article');
    }
}
