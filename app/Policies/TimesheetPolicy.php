<?php

namespace App\Policies;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TimesheetPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function edit(User $user, Timesheet $timesheet): bool
    {
        return $user->hasRole('admin') || ($user->id == $timesheet->user->id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Timesheet $timesheet): bool
    {
        return $user->hasRole('admin') || ($user->id == $timesheet->user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Timesheet $timesheet): bool
    {
        return $user->hasRole('admin') || ($user->id == $timesheet->user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function approve(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
