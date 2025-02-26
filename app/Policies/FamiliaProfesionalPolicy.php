<?php

namespace App\Policies;

use App\Models\FamiliaProfesional;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FamiliaProfesionalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // Añado ? para que pueda ser anonimo
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    // Añado ? para que pueda ser anonimo
    public function view(?User $user, FamiliaProfesional $familiaProfesional): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    // Solo el administrador puede crear
    public function create(User $user): bool
    {
        return $user->esAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    // Solo el administrador puede actualizar
    public function update(User $user, FamiliaProfesional $familiaProfesional): bool
    {
        return $user->esAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    // Solo el administrador puede borrar
    public function delete(User $user, FamiliaProfesional $familiaProfesional): bool
    {
        
        return $user->esAdmin();

       }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FamiliaProfesional $familiaProfesional): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FamiliaProfesional $familiaProfesional): bool
    {
        return false;
    }
}
