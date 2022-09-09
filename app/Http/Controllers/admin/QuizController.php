<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\quiz\StoreRequest;
use App\Http\Requests\quiz\UpdateRequest;
use App\Services\QuizService;
use App\Utility\File;
use Exception;
use Illuminate\Http\Request;


class QuizController extends Controller
{

    private $quizServ;

    public function __construct(QuizService $quizServ)
    {
        $this->quizServ = $quizServ;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
  
        if($request->ajax()){

          $quizes = $this->quizServ->ajaxQuizes();
          return $quizes;
        }

        return view('admin.quiz.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view("admin.quiz.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
         $data  =  $request->all();

        if(isset($request->quiz_price)){
            $request->validate([
              'price' => 'required'
            ]);

            $data['price'] = $request->price;
        }
        else{
          $data['price'] = 0;
        }
    
        try{

          if($request->has("show_ans")){
            $data["show_ans"] = 1;
          }
          else{
            $data["show_ans"] = 0;
          }
          if($request->has("show_each_ans")){
             $data["show_each_ans"] = 1;
      
         }
         else{
          $data["show_each_ans"] = 0;
         }

          $data["picture"] = File::imageUpload($request->file("picture"),File::QUIZPATH);
          $this->quizServ->createQuiz(($data));        
          Toastr()->success("","Quiz added successfully");

        }catch(Exception $e)
        {

            toastr()->error("",$e->getMessage());
        }

        return back();
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      try{

        $quiz = $this->quizServ->findQuiz($id);


      }catch(Exception $e)
      {
          toastr()->error($e->getMessage());
      }

      return view('admin.quiz.edit',compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        if(isset($request->quiz_price)){
          $request->validate([
            'price' => 'required'
          ]);
        }
        else{

          $data['price'] = 0;
        }


         try{

            $data = $request->all();

            if($request->has("show_ans")){
              $data["show_ans"] = 1;
            }
            else{
              $data["show_ans"] = 0;
            }
            if($request->has("show_each_ans")){
               $data["show_each_ans"] = 1;
            }
            else{
                $data["show_each_ans"] = 0;
           }


            $quiz =  $this->quizServ->findQuiz($id);
            
            if($request->hasFile("picture")){

                $file = $request->file("picture");
                $imageName = File::imageUpload($file,File::QUIZPATH);
                File::unlinkPhoto(File::QUIZPATH.$quiz->picture);
                $data['picture'] = $imageName;
            }
              
            
            $this->quizServ->updateQuiz($data, $quiz);

            toastr()->success("","Quiz information updated success");

         }catch(Exception $e){

           toastr()->error("",$e->getMessage());
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

          $quiz =  $this->quizServ->findQuiz($id);
          $this->quizServ->deleteQuiz($quiz);

         toastr()->success('deleted', 'Quiz has been deleted');

      }catch(Exception $e){

          return toastr()->error('deleted',$e->getMessage());
       }


       return back();
    }
}
