<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoPost extends Model
{
    //Laravel cosi non gestisce date create_at e update_at
    public $timestamps = false;

    /**
     *  DB RELATIONS
     **/

     // info_posts - posts (one-to-one   -- da tab secondaria a principale)
     public function post() {
        return $this->belongsTo('App\Post');
     }
}
