<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizUser extends Model
{
    public $table = "quiz_user";
    protected $fillable = [
        'user_id',
        'quiz_id',
        'status',
        'amount',
      ];


    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function quiz()
    {
      return $this->belongsTo(Quiz::class);
    }
}
