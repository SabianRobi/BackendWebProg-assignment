<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        Gate::define('create-label', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('edit-label', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('create-item', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('edit-item', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('delete-item', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('delete-label', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('create-comment', function () {
            return Auth::check();
        });

        Gate::define('edit-comment', function (User $user, Comment $comment) {
            return ($comment->user_id == $user->id) || $user->is_admin;
        });

        Gate::define('delete-comment', function (User $user, Comment $comment) {
            return ($comment->user_id == $user->id) || $user->is_admin;
        });
    }
}
