<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\QuizUser;
use App\Services\QuizUserService;

class TransactionController extends Controller
{
    private $quizUserService;

    public function __construc(QuizUserService $quizUserService)
    {
        $this->quizUserService = $quizUserService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $trans = QuizUser::paginate(8);

         return view("admin.transactions.index",compact("trans"));
    }

}
