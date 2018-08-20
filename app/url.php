<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class url extends Model
{
    protected $fillable = ['url'];
    public function UrlPages()
    {
        return $this->belongsToMany('App\UrlPages');
    }
}
