<?php
namespace App\Services;

use App\Models\Question;
use App\Models\Quiz;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class QuestionService{

    public function all()
    {
        $questions = Question::all();

        return $questions;
    }

     public function ajaxQuestions(Quiz $quiz)
     {
        $questions = Question::where('quiz_id', $quiz->id)->select('id','question','a','b','c','d','e','f','ans');
        return DataTables::of($questions)
        ->addIndexColumn()
        ->addColumn('question',function($row){
            return $row->question;
        })
        ->addColumn('a',function($row){
            return $row->a;
        })
        ->addColumn('b',function($row){
            return $row->b;
        })
        ->addColumn('c',function($row){
            return $row->c;
        })
        ->addColumn('d',function($row){
            return $row->d;
        })
        ->addColumn('e',function($row){
            return $row->e;
        })
        ->addColumn('f',function($row){
            return $row->f;
        })
        ->addColumn('ans',function($row){
            return $row->ans;
        })

        ->addColumn('action', function($row){

            $btn = '<div class="admin-table-action-block">

                <a href="' . route('admin.questions.edit', $row->id) . '" data-toggle="tooltip" data-original-title="Edit" class="btn btn-primary btn-floating"><i class="fa fa-pencil"></i></a>
              
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
                    <form method="POST" action="' . route("admin.questions.destroy", $row->id) . '">
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
        ->rawColumns(['question','a','b','c','d','e','f','ans','action'])
        ->make(true);
     }

     public function questionSelect($questionId)
     {
        $question =  Question::select(DB::raw("REPLACE(ans,',','') as ans"))->where("id",$questionId)->first();
        return $question;
     }


     public function findQuestion($id)
     {
        try{

            $quiz = Question::findOrFail($id);

            return $quiz;
         
        }catch(Exception $e)
        {
             throw new Exception($e->getMessage());
        }
     }


     public function questionsWhere($columnName, $value)
     {
        $questions = Question::where($columnName, $value)->get();

        return $questions;
     }


    public function createQuestion(array $data)
    {
       $question = Question::create($data);

       return  $question;
    }


    public function update(array $data, Question $question)
    {
        $question->update($data);
    }

    public function deleteQuestion(Question $question)
    {
        $question->delete();
    }
}