<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AnswerService;
use App\Services\QuestionService;
use App\Services\QuizUserToookService;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    private $quizService;
    private $questionService;
    private $answerService;
    private $quizUserTookService;

    public function __construct(
            QuizService $quizService, 
            QuestionService $questionService, 
            AnswerService $answerService,
            QuizUserToookService $quizUserTookService
        )
    {
        $this->quizService = $quizService;
        $this->questionService = $questionService;
        $this->answerService = $answerService;
        $this->quizUserTookService  = $quizUserTookService;
    }


    public function startQuiz($id)
    {
       
        $quiz = $this->quizService->findQuiz($id);

        $this->authorize("quiz-access", $quiz);

        
        // set up number of taken user took this quiz
         $userTook= $this->quizUserTookService->find(auth()->user()->id, $id);

          if(!$userTook)
          {
            $this->quizUserTookService->create([
                'quiz_id' => $id,
                "user_id" => auth()->user()->id,
                "user_taken" => 1,
            ]);
          }
            else if($userTook && ($userTook->user_taken == $quiz->number_of_taken))
            {
                Session::flash('error', 'You already taken this quiz');
                return redirect()->intended("/home");
            }
            else if($userTook && $userTook->is_seen)
            {
                Session::flash('error', 'You already seen the answers');
                return redirect()->intended("/home");
            }
            else{

                $this->quizUserTookService->update($userTook);
            }
    

        $questions = $this->questionService->questionsWhere('quiz_id',$id);
        $auth = Auth::user();

        return view("questions",compact("quiz","auth","questions"));
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $ans = $this->answerService->answerWheres([
            'user_id' => auth()->user()->id,
            'quiz_id' => $request->quiz_id,
            'question_id' => $request->question_id
        ]);
  
        $question = $this->questionService->questionSelect($request->question_id);
 
        $questionAns = sortStr($question->ans);
        $userAns = sortStr($request->user_ans);

        if($questionAns == $userAns){
            $input['is_correct'] = true;
        }

       
        // if answer already added then update it else added answer
        if($ans){
            $ans->update($input);
        }
        else{
           
            $this->answerService->createAnswer($input);
        }

        return response()->json([
            "success" => true,
        ]);
    }

    
    public function finish($id)
    {
        $quiz =  $this->quizService->findQuiz($id);

        // check retake availabel or not 
        $retake = true;
        $userTook= $this->quizUserTookService->find(auth()->user()->id, $id);
        if($userTook && ($userTook->user_taken == $quiz->number_of_taken))
        {
           $retake = false;
        }
        else if($userTook && $userTook->is_seen)
        {
            $retake = false;
        }

        
        $auth = Auth::user();

        // authorization check 

        $this->authorize("quiz-access",$quiz);

        $questions = $this->questionService->questionsWhere('quiz_id',$id);

        $countQues = $questions->count();

        $answers =  $this->answerService->answersWheres([
                'user_id' => $auth->id,
                'quiz_id' => $id
        ]);


        /// if not  gave all answers, added them

        if($answers == null || ($countQues != $answers?->count())){
        
            foreach($questions as $question){ 
              $added = false;   
              foreach($answers as $ans){ 
                    if($question->id == $ans?->question_id){ 
                        $added = true;
                    }
              }
              if($added == false){  
                  $data["quiz_id"] = $id;
                  $data['user_id'] = $auth->id;
                  $data['question_id'] = $question->id;

                  $this->answerService->createAnswer($data);
              }
            }
          }



          $answers =  $this->answerService->answersWheres([
            'user_id' => $auth->id,
            'quiz_id' => $id
            ]);
   
        
        return view('finish', compact('answers',"countQues",'quiz',"retake"));
    }

    public function storeSeen(Request $request)
    {
        Validator::make($request->all(),[
            "quiz_id" => "required",
        ]);

        $userTook= $this->quizUserTookService->find(auth()->user()->id, $request->quiz_id);
        $this->quizUserTookService->update($userTook,true);

        return response()->json([
            "success" => false,
        ]);
    }
}
