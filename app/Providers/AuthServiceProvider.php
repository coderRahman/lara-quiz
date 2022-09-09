<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\QuizUser;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('quiz-access', function ($user, $quiz) {
            if($quiz->price == 0){
                return true;
            }
              
            else if(QuizUser::where("quiz_id", $quiz->id)->where("user_id",$user->id)->exists()){
                return true;
            }
            
            return false;
        });
    }
}
