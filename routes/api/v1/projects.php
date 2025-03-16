<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Project\ProjectsController;
use App\Http\Controllers\API\Timesheet\TimesheetLogsController;

/*
|--------------------------------------------------------------------------
| API Projects Routes
|--------------------------------------------------------------------------
|
| The following routes are included in the `routes/api.php` routes under
| `api/v1` namespace.
|
*/

# Guarded by API auth.
Route::middleware('auth:api')->group(function () {

    # Projects.
    Route::apiResource('projects', ProjectsController::class);

    # Timesheet.
    Route::prefix('timesheet')->group(function () {

        # Timesheet logs
        Route::apiResource('logs', TimesheetLogsController::class)->parameters(['logs' => 'timesheetLog']);

    });

});
