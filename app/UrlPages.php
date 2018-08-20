<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlPages extends Model
{
    protected $fillable = ['sub_urls', 'tf_words'];
    public function urls()
    {
        return $this->hasMany('App\url', 'foreign_key', 'searched_url');
    }
}
