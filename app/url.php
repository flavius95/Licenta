<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class url extends Model
{
    protected $fillable = ['url', 'sub_urls', 'data'];
}
