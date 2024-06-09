<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the timesheet.
     */
    public function index(Request $request)
    {
        //admin user can filter user list
        $users = [];
        if ($request->user()->hasRole('admin')) {
            $users = User::get();
            if ($request->get('user', null)) {
                $timesheets = Timesheet::with('user')->whereHas('user', function ($query) {
                    $query->whereNull('deleted_at');
                })->where('user_id', $request->get('user'))->orderBy('date', 'DESC')->orderBy('time_in', 'ASC')->get();
            } else {
                $timesheets = Timesheet::with('user')->whereHas('user', function ($query) {
                    $query->whereNull('deleted_at');
                })->orderBy('date', 'DESC')->orderBy('time_in', 'ASC')->get();
            }
        } else {
            $timesheets = Timesheet::with('user')->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })->where('user_id', $request->user()->id)->orderBy('date', 'DESC')->orderBy('time_in', 'ASC')->get();
        }

        return view('dashboard', ['object' => 'timesheet', 'mode' => 'list', 'timesheets' => $timesheets, 'users' => $users]);
    }

    /**
     * Show the form for creating a new timesheet.
     */
    public function create()
    {
        return view('components.timesheet.timesheet-view', ['object' => 'timesheet', 'mode' => 'create']);
    }

    /**
     * Show the form for editing the timesheet.
     */
    public function edit(Request $request, Timesheet $timesheet)
    {
        $this->authorize('edit', $timesheet);
        return view('components.timesheet.timesheet-view', ['object' => 'timesheet', 'mode' => 'edit', 'timesheet' => $timesheet]);
    }
}
