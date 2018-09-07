<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['link', 'topics', 'details'];
    protected $table = 'url';
        // Primary Key
    public $primaryKey = 'id';

}
