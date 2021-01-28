<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'slug',
        'path_img'
    ];

    /**
     *  DB RELATIONS
     **/

     // posts - tags (many-to-many)
     public function tags() {
         return $this->belongsToMany('App\Tag');
     }
}
