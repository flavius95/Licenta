<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['url'];
    protected $table = 'url';
        // Primary Key
    public $primaryKey = 'id';
    public function pages()
    {
        return $this->hasMany('App\Pages');
    }
}
