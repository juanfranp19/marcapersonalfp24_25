<?php

namespace App\Providers;

use App\Models\Curriculo;
use App\Models\FamiliaProfesional;
use App\Models\Idiomas;
use App\Models\User;
use App\Policies\CurriculoPolicy;
use App\Policies\FamiliaProfesionalPolicy;
use App\Policies\IdiomaPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
        Gate::before(function (User $user, string $ability) {
            if ($user->esAdmin()) {
                return true;
            }
        });
        Gate::policy(Curriculo::class, CurriculoPolicy::class);
        Gate::policy(FamiliaProfesional::class, FamiliaProfesionalPolicy::class);
        Gate::policy(Idiomas::class, IdiomaPolicy::class);
    }
}
