<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'quiz_id',
        'question',
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'ans'
      ];
  
      public function answer() {
        return $this->hasOne(Answer::class);
      }
  
      public function topic() {
        return $this->belongsTo('App\Topic');
      }
}
