<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
use App\Services\Timesheet\ApproveTimesheet;
use App\Services\Timesheet\CreateTimesheet;
use App\Services\Timesheet\DeleteTimesheet;
use App\Services\Timesheet\UpdateTimesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
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
                $timesheets = Timesheet::whereHas('user', function ($query) {
                    $query->whereNull('deleted_at');
                })->where('user_id', $request->get('user'))->get();
            } else {
                $timesheets = Timesheet::whereHas('user', function ($query) {
                    $query->whereNull('deleted_at');
                })->get();
            }
        } else {
            $timesheets = Timesheet::whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })->where('user_id', $request->user()->id)->get();
        }

        return view('dashboard', ['object' => 'timesheet', 'mode' => 'list', 'timesheets' => $timesheets, 'users' => $users]);
    }

    /**
     * Show the form for creating a new timesheet.
     */
    public function create()
    {
        return view('dashboard', ['object' => 'timesheet', 'mode' => "create"]);
    }

    /**
     * Store a newly created timesheet in storage.
     */
    public function store(Request $request)
    {
        $request->request->set('user_id', $request->user()->id);
        $result = app(CreateTimesheet::class)->execute($request->all());

        if (!$result instanceof Timesheet) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result);
        }

        return redirect()->route('timesheet.index');
    }

    /**
     * Show the form for editing the timesheet.
     */
    public function edit(Request $request, Timesheet $timesheet)
    {
        if ($request->user()->id == $timesheet->user->id) {
            return view('dashboard', ['object' => 'timesheet', 'mode' => "edit", 'timesheet' => $timesheet]);
        } else {
            return view('dashboard', ['object' => 'timesheet', 'mode' => "view", 'timesheet' => $timesheet]);
        }
    }

    /**
     * Update timesheet in storage.
     */
    public function update(Request $request, Timesheet $timesheet)
    {
        $request->request->set('id', $timesheet->id);
        $result = app(UpdateTimesheet::class)->execute($request->all());

        if ($result !== true) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result);
        }

        return redirect()->route('timesheet.index');
    }

    /**
     * Remove timesheet from storage.
     */
    public function destroy(Timesheet $timesheet)
    {
        $result = app(DeleteTimesheet::class)->execute(['id' => $timesheet->id]);

        if ($result !== true) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result);
        }
        return redirect()->route('timesheet.index');
    }

    /**
     * Approve timesheet.
     */
    public function approve(Timesheet $timesheet)
    {
        $result = app(ApproveTimesheet::class)->execute(['id' => $timesheet->id]);

        if ($result !== true) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result);
        }

        return redirect()->route('timesheet.index');
    }
}
