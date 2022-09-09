<?php
namespace App\Services;

use App\Models\Answer;

class AnswerService {

    public function all()
    {
        $ans = Answer::all();

        return $ans;
    }

    public function createAnswer(array $data)
    {
       $ans =  Answer::create($data);
       
       return $ans;
    }


    public function answerWheres($where)
    {
        $ans = Answer::where($where)->first();

        return $ans;
    }

    public function answersWheres($where)
    {
       $ans = Answer::where($where)->get();

       return $ans;
    }
}


?>