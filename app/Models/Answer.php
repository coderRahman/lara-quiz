<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'quiz_id', 'user_id', 'question_id', 'user_ans','is_correct'
      ];
  
      public function user(){
        return $this->belongsTo(User::class);
      }
  
      public function question(){
        return $this->belongsTo(Question::class);
      }
  
      public function quiz() {
        return $this->belongsTo(quiz::class);
      }
  
   
}
