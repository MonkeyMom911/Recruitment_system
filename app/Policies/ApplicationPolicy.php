<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return bool
     */
    public function view(User $user, Application $application)
    {
        // Aturan #1: Pelamar dapat melihat lamarannya sendiri.
        if ($user->id === $application->user_id) {
            return true;
        }

        // Aturan #2: Admin dapat melihat lamaran apa pun.
        if ($user->isAdmin()) {
            return true;
        }
        
        // Aturan #3 (Paling Penting): HRD hanya dapat melihat lamaran
        // untuk lowongan pekerjaan yang dia buat sendiri.
        if ($user->isHRD()) {
            return $user->id === $application->jobVacancy->created_by;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        // Hanya pelamar yang dapat membuat lamaran.
        return $user->isApplicant();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return bool
     */
    public function update(User $user, Application $application)
    {
        // Admin dapat memperbarui lamaran apa pun.
        if ($user->isAdmin()) {
            return true;
        }

        // HRD hanya dapat memperbarui lamaran untuk lowongan yang dia buat.
        if ($user->isHRD()) {
            return $user->id === $application->jobVacancy->created_by;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return bool
     */
    public function delete(User $user, Application $application)
    {
        // Hanya Admin yang dapat menghapus lamaran.
        return $user->isAdmin();
    }
}
