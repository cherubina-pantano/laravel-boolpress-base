<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     *  DB RELATIONS
     **/

     //comments - posts (one-to-many  --- oggetto perchè dalla parte del one)
     public function post() {
         return $this->belongsTo('App\Post');
     }
}
