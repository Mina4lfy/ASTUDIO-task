<?php

namespace App\Http\Controllers\API\Timesheet;

# controllers.
use App\Http\Controllers\Controller;

# requests.
use App\Http\Requests\Request;
use App\Http\Requests\Timesheet\TimesheetLogRequest;

# models.
use App\Models\Project\Project;
use App\Models\Timesheet\TimesheetLog;

# resources.
use App\Http\Resources\Timesheet\TimesheetLogResource;

class TimesheetLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\Request $request
     * @param mixed $project
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, ?Project $project = null)
    {
        $query = $project ? $project->timesheetLogs() : TimesheetLog::query();

        $query->with('user');

        $query = TimesheetLog::search($request->filter, $query);

        $timesheetLogs = $query->paginate($request->per_page);

        return TimesheetLogResource::collection($timesheetLogs);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\BaseModel $model
     * @return TimesheetLogResource
     */
    public function show(TimesheetLog $timesheetLog)
    {
        $timesheetLog->loadMissing('user', 'project');

        return TimesheetLogResource::make($timesheetLog);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Timesheet\TimesheetLogRequest $request
     * @return TimesheetLogResource
     */
    public function store(TimesheetLogRequest $request)
    {
        # Assign the new timehseet log to the currently logged-in user.
        $request->merge(['user_id' => $request->user()?->id]);

        $timesheetLog = TimesheetLog::create($request->all());

        return $this->show($timesheetLog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Timesheet\TimesheetLogRequest $request
     * @param \App\Models\BaseModel $model
     * @return TimesheetLogResource
     */
    public function update(TimesheetLogRequest $request, TimesheetLog $timesheetLog)
    {
        $timesheetLog->update($request->except('project_id', 'user_id'));

        return $this->show($timesheetLog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\BaseModel $model
     * @return TimesheetLogResource
     */
    public function destroy(TimesheetLog $timesheetLog)
    {
        $timesheetLog->delete();

        return response()->json(['data' => null, 'message' => 'Deleted successfully.']);
    }
}
