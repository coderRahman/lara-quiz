<?php
namespace App\Services;

use App\Models\QuizUser;

class PaymentService{

    public function totalIncome()
    {
        $income = QuizUser::sum("amount");

        return $income;
    }

    public  function stripe($price, $stripeToken)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
       
        $stripe = \Stripe\Charge::create ([
                "amount" =>  $price,
                "currency" => "usd",
                "source" => $stripeToken,
                "description" => "Test payment "
        ]);

        return  $stripe;
    }

}