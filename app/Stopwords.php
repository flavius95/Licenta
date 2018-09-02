<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stopwords extends Model
{
    protected $fillable = ['language', 'words'];
    
}
