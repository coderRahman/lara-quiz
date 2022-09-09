<?php

namespace App\Models;

use App\Utility\File;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{

   use HasFactory;
  public $table = "quizes";
    protected $fillable = [
         'name',
         'picture', 
         'description', 
         'per_question_mark',
         'price','time',
         'is_time_questions',
         'show_ans',
         'number_of_taken',
         'show_each_ans'
      ];

      protected function picture():Attribute
      {
        return new Attribute(
          get: fn ($value) => File::QUIZPATH.'/'.$value,
        );
      }
  
      public function questions(){
        return $this->hasMany(Question::class);
      }

      public function totalQuestions()
      {
        return $this->hasOne(Question::class);
      }
  
      public function answers(){
        return $this->hasMany(Answer::class);
      }

      
      public function user() {
        return $this->belongsToMany(User::class,'quiz_user')
           ->withPivot('amount','transaction_id', 'status')
          ->withTimestamps();
      }
}
