<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class url extends Model
{
    protected $fillable = ['url'];
    public function UrlPagesId()
    {
        return $this->belongsToMany('App\Http\Http\UrlPages');
    }
}
