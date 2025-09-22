<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
class ProjectController extends Controller
{
    public function latestprojects()
    {
       $projects = Project::latest()->take(3)->get();
       return ProjectResource::collection($projects)->resolve();
    }

    public function all(){
        $projects=Project::paginate(6);
         return ProjectResource::collection($projects)
        ->additional([
            'meta' => [
                'current_page' => $projects->currentPage(),
                'last_page'    => $projects->lastPage(),
                'per_page'     => $projects->perPage(),
                'total'        => $projects->total(),
            ]
        ]);
    
    
    }


    public function show($slug){
       
        $project = Project::where('slug',$slug)->first();
            
        if ($project) {
            return new ProjectResource($project);
        }

        return response()->json([
            'message' => 'Project not found'
        ], 404);
        }
}
