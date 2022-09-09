<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use App\Services\UserService;

class DashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserService $user, PaymentService $pay)
    {
        $noUsers = $user->totalUsers();
        $paidNoUsers = $user->paidTotalUsers();
         $income = $pay->totalIncome();

        return view("admin.dashbaord",compact("noUsers","paidNoUsers","income"));
       
    }
}
