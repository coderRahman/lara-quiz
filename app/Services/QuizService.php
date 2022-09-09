<?php
namespace App\Services;

use App\Models\Quiz;
use App\Models\QuizUser;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class QuizService{

    public function ajaxQuizes()
    {
        $quizes = Quiz::select('id','name','picture','description','per_question_mark','time');
        return DataTables::of($quizes)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('picture',function($row){
               return  $image = '<img src="' . asset('/'.$row->picture) . '" alt="Pic" width="50px" class="img-responsive">';
            })
            ->addColumn('description',function($row){
                return $row->description;
            })
            ->addColumn('per_question_mark',function($row){
               return  $row->per_question_mark;
            })
            ->addColumn('time',function($row){
                return $row->time;
            })

            ->addColumn('action',function($row){
              $btn = '<div class="admin-table-action-block">

                    <a href="' . route('admin.quizes.edit', $row->id) . '" data-toggle="tooltip" data-original-title="Edit" class="btn btn-primary btn-floating"><i class="fa fa-edit"></i></a>
                  
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal' . $row->id . '"><i class="fa fa-trash"></i> </button></div>';

                   


                     $btn .= '<div id="deleteModal' . $row->id . '" class="delete-modal modal fade" role="dialog">
                  <div class="modal-dialog modal-sm">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="delete-icon"></div>
                      </div>
                      <div class="modal-body text-center">
                        <h4 class="modal-heading">Are You Sure ?</h4>
                        <p>Do you really want to delete these records? This process cannot be undone.</p>
                      </div>
                      <div class="modal-footer">
                        <form method="POST" action="' . route("admin.quizes.destroy", $row->id) . '">
                          ' . method_field("DELETE") . '
                          ' . csrf_field() . '
                            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>';
              return $btn;
            })
            ->rawColumns(['name','picture','description','time','action'])
            ->make(true);
    }


    public function quizesQuestions()
    {
        $quizes = Quiz::with(["totalQuestions"=>function($quesion){
            $quesion->select('quiz_id',DB::raw('count(quiz_id) as  no_questions'))->groupBy('quiz_id');
         }])->with("answers")->get();

         return $quizes;
    }

    public function createQuiz(array $data)
    {
        $quiz = Quiz::create($data);

        return $quiz;
    }


    public function createQuizUser($userId, $quizId, $stripe)
    {
        QuizUser::create([
            "user_id" => $userId,
            "quiz_id" => $quizId,
            "status" => $stripe->status,
            "amount" => $stripe->amount
        ]);
    }


    public function findQuiz($id)
    {
        try{

            $quiz = Quiz::findOrFail($id);
            return $quiz;

        }catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

   


    public function updateQuiz(array $data, Quiz $quiz)
    {
        $quiz->name = $data['name'];
        $quiz->description = $data['description'];
        $quiz->per_question_mark = $data['per_question_mark'];
        $quiz->time = $data['time'];
        $quiz->number_of_taken = $data['number_of_taken'];
        $quiz->show_ans = $data['show_ans'];
        $quiz->show_each_ans = $data['show_each_ans'];
        $quiz->price = $data['price'];
        if($data['picture']){
            $quiz->picture = $data['picture'];
        }
        $quiz->save();
    }


    public function deleteQuiz(Quiz $quiz)
    {
        $quiz->delete();
    }
}