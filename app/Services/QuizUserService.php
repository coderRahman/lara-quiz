<?php
namespace App\Services;

use App\Models\QuizUser;

class QuizUserService{

    public function transactions()
    {
        $trans = QuizUser::paginate(8);

        return $trans;
    }

    public function userTransaction($id)
    {
        $trans = QuizUser::where("user_id",$id)->paginate(10);

        return $trans;
    }
}