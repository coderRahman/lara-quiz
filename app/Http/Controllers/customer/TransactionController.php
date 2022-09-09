<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\QuizUser;
use App\Services\QuizUserService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QuizUserService $quizUserService)
    {
        $trans = $quizUserService->userTransaction(auth()->user()->id);

        return  view("customer.transaction.index",compact("trans"));
    }

}
