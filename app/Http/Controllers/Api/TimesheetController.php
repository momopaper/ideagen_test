<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TimesheetResource;
use App\Models\Timesheet;
use App\Models\User;
use App\Services\Timesheet\ApproveTimesheet;
use App\Services\Timesheet\CreateTimesheet;
use App\Services\Timesheet\DeleteTimesheet;
use App\Services\Timesheet\UpdateTimesheet;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a newly created timesheet in storage.
     */
    public function store(Request $request)
    {
        $request->request->set('user_id', $request->user()->id);
        $result = app(CreateTimesheet::class)->execute($request->all());

        if (!$result instanceof Timesheet) {
            return response()->json([
                'success' => false,
                'errors' => $result->errors()
            ], 422);
        }

        return response()->json(['success' => true, 'result' => new TimesheetResource($result)]);
    }

    /**
     * Update timesheet in storage.
     */
    public function update(Request $request, Timesheet $timesheet)
    {
        $this->authorize('update', $timesheet);
        $request->request->set('id', $timesheet->id);
        $result = app(UpdateTimesheet::class)->execute($request->all());

        if ($result !== true) {
            return response()->json([
                'success' => false,
                'errors' => $result->errors()
            ], 422);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove timesheet from storage.
     */
    public function destroy(Timesheet $timesheet)
    {
        $this->authorize('delete', $timesheet);
        $result = app(DeleteTimesheet::class)->execute(['id' => $timesheet->id]);

        if ($result !== true) {
            return response()->json([
                'success' => false,
                'errors' => $result->errors()
            ], 422);
        }
        return response()->json(['success' => true]);
    }

    /**
     * Approve timesheet.
     */
    public function approve(Timesheet $timesheet)
    {
        $this->authorize('approve', $timesheet);
        $result = app(ApproveTimesheet::class)->execute(['id' => $timesheet->id]);

        if ($result !== true) {
            return response()->json([
                'success' => false,
                'errors' => $result->errors()
            ], 422);
        }

        return response()->json(['success' => true]);
    }
}
