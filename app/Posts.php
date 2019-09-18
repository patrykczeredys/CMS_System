<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = array('category_id','title','author','image','short_desc','description');

    public function category() {

        return $this->belongsTo('category');
    }
}
