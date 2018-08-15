<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlPages extends Model
{
    protected $fillable = ['searched_url', 'sub_urls', 'tf_words'];
    public function urls()
    {
        return $this->belongsToMany('App\Http\url');
    }
}
