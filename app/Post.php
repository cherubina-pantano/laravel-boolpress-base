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

     // posts - info_posts (one-to-one)
     public function infoPost() {
        return $this->hasOne('App\InfoPost');
     }

     //posts - comments (one-to-many   --- parte del many: collezione)
     public function comments() {
        return $this->hasMany('App\Comment');
    }

     // posts - tags (many-to-many)
     public function tags() {
         return $this->belongsToMany('App\Tag');
     }
}
