<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizUser;
use App\Services\PaymentService;
use App\Services\QuizService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{


    public function stripe($id, QuizService $quizService)
    {
        $quiz = $quizService->findQuiz($id);

        return view('payment',compact("quiz"));
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request, QuizService $quizService, PaymentService $paymentService)
    {
        try{

            $quiz = $quizService->findQuiz($request->quiz_id);
            $stripe = $paymentService->stripe($request->price, $request->stripeToken);

            $quizService->createQuizUser(auth()->user()->id, $request->quiz_id, $stripe);
        
            Session::flash('success', 'Payment successful!');

        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
        }
       return back();
    }
}
