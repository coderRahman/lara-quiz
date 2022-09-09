<?php

use App\Http\Controllers\admin\DashBoardController;
use App\Http\Controllers\admin\QuestionController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\QuizController;
use App\Http\Controllers\admin\TopReportController;
use App\Http\Controllers\admin\TransactionController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\customer\TransactionController as CustomerTransactionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController as ControllersQuizController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;


Route::redirect('/',"/home");


///  route for admin panel 

Route::group([ "prefix" => "admin", "as"=> "admin.", 'middleware'=> 'IsAdmin' ], function(){

    Route::get("/dashbaord",[DashBoardController::class,"index"]);
    Route::resource("/quizes",QuizController::class)->except("show");
    Route::resource("/questions",QuestionController::class)->except("create");
    Route::resource("/users",UserController::class)->except(["create","show"]);
    Route::resource("/reports",ReportController::class);
    Route::get("/transactions",[TransactionController::class,"index"])->name("transactions.index");

});

// auth routes
Auth::routes();


  // customer panel route
Route::group([ "prefix" => "customer", "as"=> "customer."], function(){
    Route::get("/dashbaord",function(){
        return view("customer.index");
    });

    Route::get("/transactions",[CustomerTransactionController::class,"index"])->name("transactions.index");
});

   // site routes
Route::get("/home",[HomeController::class,"index"]);

Route::group(["middleware" => "IsCustomer"],function(){

    Route::controller(ControllersQuizController::class)->group(function(){

        Route::get("/start-quiz/{id}","startQuiz")->name("start.quiz")->middleware("IsCustomer");
        Route::post("/quiz/ans-store","store");
        Route::get('start-quiz/{id}/finish','finish');
        Route::post("/quiz/is-seen","storeSeen");
    });

    // payments
    Route::get('pay/{quizId}', [PaymentController::class, 'stripe']);
    Route::post('pay', [PaymentController::class, 'stripePost'])->name('pay');
  
});

