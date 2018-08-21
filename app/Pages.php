<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $fillable = ['sub_urls', 'tf_words'];
    protected $table = 'pages';
        // Primary Key
    public $primaryKey = 'id';
    public function url()
    {
        return $this->belongsTo('App\Url');
    }
}
