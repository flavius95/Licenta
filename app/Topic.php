<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['topic', 'word'];
    public $timestamps = false;

    public static function arrangeTopics(array $data) : array
    {
        $result = [];
        if (count($data)) {
          foreach ($data as $item) {
              if(!isset($result[$item['topic']])) {
                $result[$item['topic']] = [$item['word']];
              } else {
                $result[$item['topic']][] = $item['word'];
              }
          }
        }
        return $result;
    }

}
