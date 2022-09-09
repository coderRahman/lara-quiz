<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizes = Quiz::all();
        $questions = Question::all();
        return view('admin.reports.index', compact('quizes', 'questions'));
    }

   
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Quiz::findOrFail($id);
        $answers = Answer::where('quiz_id', $topic->id)->get();
        $students = User::where('id', '!=', Auth::id())->get();
        $c_que = Question::where('quiz_id', $id)->count();

        $filtStudents = collect();
        foreach ($students as $student) {
          foreach ($answers as $answer) {
            if ($answer->user_id == $student->id) {
              $filtStudents->push($student);
            }
          }
        }

        $filtStudents = $filtStudents->unique();
        $filtStudents = $filtStudents->flatten();

        return view('admin.reports.show', compact('filtStudents', 'answers', 'c_que', 'topic'));
    }

    
}
