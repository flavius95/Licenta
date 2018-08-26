<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['url', 'tf_words'];
    protected $table = 'url';
        // Primary Key
    public $primaryKey = 'id';
    public function pages()
    {
        return $this->hasMany('App\Pages');
    }
}
