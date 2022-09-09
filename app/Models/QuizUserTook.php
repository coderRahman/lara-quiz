<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizUserTook extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'user_taken',
        'is_seen'
    ];
    
}
