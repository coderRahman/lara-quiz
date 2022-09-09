<?php

namespace App\Services;

use App\Models\QuizUserTook;

class QuizUserToookService{

    public function create(array $data)
    {
        $obj = QuizUserTook::create($data);

        return $obj;
    }

    public function find($userId, $quizId)
    {
        $obj = QuizUserTook::where("user_id",$userId)->where("quiz_id", $quizId)->first();

        return $obj;
    }


    public function update(QuizUserTook $obj,  $isSeen = false, int  $took = 1)
    {
        $obj->is_seen = $isSeen;
        $obj->user_taken = $obj->user_taken + $took;
        $obj->save();
    }

}