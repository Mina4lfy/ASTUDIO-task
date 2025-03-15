<?php

namespace App\Http\Controllers\API\Project;

# controllers
use App\Http\Controllers\Controller;

# requests
use App\Http\Requests\Request;
use App\Http\Requests\Project\ProjectRequest;

# models
use App\Models\Project\Project;

# resources
use App\Http\Resources\Project\ProjectResource;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Project::query();

        $projects = $query->paginate($request->per_page);

        return ProjectResource::collection($projects);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project\Project $project
     * @return ProjectResource
     */
    public function show(Project $project)
    {
        $project->loadMissing('assignees');
        $project->loadCount('assignees');

        return ProjectResource::make($project);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Project\ProjectRequest $request
     * @return ProjectResource
     */
    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->all());

        return $this->show($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Project\ProjectRequest $request
     * @param \App\Models\Project\Project $project
     * @return ProjectResource
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        return $this->show($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project\Project $project
     * @return ProjectResource
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(['data' => null]);
    }
}
