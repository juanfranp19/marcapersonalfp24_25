<?php

namespace App\Providers;

use App\Models\Actividad;
use App\Models\Ciclo;
use App\Models\Competencia;
use App\Models\Curriculo;
use App\Models\Empresa;
use App\Models\FamiliaProfesional;
use App\Models\Idiomas;
use App\Models\User;
use App\Policies\ActividadPolicy;
use App\Policies\CicloPolicy;
use App\Policies\CompetenciaPolicy;
use App\Policies\CurriculoPolicy;
use App\Policies\EmpresasPolicy;
use App\Policies\FamiliaProfesionalPolicy;
use App\Policies\IdiomaPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;

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
        Vite::prefetch(concurrency: 3);

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
        Gate::before(function (User $user, string $ability) {
            if ($user->esAdmin()) {
                return true;
            }
        });
        Gate::policy(Actividad::class, ActividadPolicy::class);
        Gate::policy(Ciclo::class, CicloPolicy::class);
        Gate::policy(Competencia::class, CompetenciaPolicy::class);
        Gate::policy(Curriculo::class, CurriculoPolicy::class);
        Gate::policy(Empresa::class, EmpresasPolicy::class);
        Gate::policy(FamiliaProfesional::class, FamiliaProfesionalPolicy::class);
        Gate::policy(Idiomas::class, IdiomaPolicy::class);
    }
}
