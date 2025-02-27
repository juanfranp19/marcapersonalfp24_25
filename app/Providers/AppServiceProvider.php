<?php

namespace App\Providers;

use App\Models\Ciclo;
use App\Models\Competencia;
use App\Models\Curriculo;
use App\Models\User;
use App\Policies\CicloPolicy;
use App\Policies\CompetenciaPolicy;
use App\Policies\CurriculoPolicy;
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
        Gate::policy(Ciclo::class, CicloPolicy::class);
        Gate::policy(Competencia::class, CompetenciaPolicy::class);
    }
}
