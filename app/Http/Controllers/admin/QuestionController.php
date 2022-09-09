<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\question\StoreRequest;
use App\Services\QuestionService;
use App\Services\QuizService;
use Exception;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    private $quizServ;

    private $quesServ;
    
    public  function __construct(QuizService $quizServ, QuestionService $quesServ)
    {
        $this->quizServ = $quizServ;
        $this->quesServ = $quesServ;
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizes = $this->quizServ->quizesQuestions();
        
        return view('admin.questions.index', compact('quizes'));
    }

   


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
       
        try{
           
          $this->quesServ->createQuestion($request->all());

           toastr()->success('added', 'Question has been added');

        }catch(Exception $e){
            toastr()->error('deleted',$e->getMessage());
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {

        $quiz = $this->quizServ->findQuiz($id);

        if($request->ajax())
        {
           $quizes = $this->quesServ->ajaxQuestions($quiz);

           return $quizes;
        }
        return view('admin.questions.show',compact("quiz"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $question = $this->quesServ->findQuestion($id);
      $quiz =  $this->quizServ->findQuiz($question->quiz_id);

     return view('admin.questions.edit',compact('question','quiz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     
        try
        {
            $question = $this->quesServ->findQuestion($id);
            
            $this->quesServ->update($request->all(),$question);

           Toastr()->success('updated', 'Question has been updated');
        }
        catch(Exception $e)
        {
           toastr()->error('deleted',$e->getMessage());
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
        try{

          $question = $this->quesServ->findQuestion($id);
          $this->quesServ->deleteQuestion($question);

           toastr()->success('deleted', 'Question has been deleted');
        }
        catch(Exception $e)
        {
           toastr()->error('deleted',$e->getMessage());
        }

        return back();
    }
}
