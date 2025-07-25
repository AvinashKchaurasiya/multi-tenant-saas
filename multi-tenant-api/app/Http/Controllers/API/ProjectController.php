<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();

        // Get active company ID
        $activeCompanyId = $user->active_company_id;

        // Fetch projects of the active company
        $projects = [];
        if ($activeCompanyId) {
            $projects = Project::where('company_id', $activeCompanyId)->paginate(10);;
        }

        return response()->json([
            'active_company_name' => optional($user->activeCompany)->name,
            'total_companies' => $user->companies()->count(),
            'projects' => $projects,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $company_id = $request->user()->active_company_id;

        if (!$company_id) {
            return response()->json(['error' => 'No active company selected.'], 403);
        }

        $project = Project::create([
            'name' => $request->name,
            'company_id' => $company_id,
        ]);

        return response()->json([
            'message' => 'Project created successfully.',
            'project' => $project,
        ]);
    }

    public function show(Request $request, Project $project){
        $user = $request->user();

        // Check if the project belongs to the active company
        if ($project->company_id != $user->active_company_id) {
            return response()->json(['error' => 'Unauthorized access to project.'], 403);
        }

        return response()->json([
            'project' => $project,
        ]);
    }
}
