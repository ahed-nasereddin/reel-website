<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function latestprojects()
    {
       $projects = Project::latest()->take(3)->get();
       return ProjectResource::collection($projects)->resolve();
    }

    public function index(){
         $projects = Project::paginate(6);

    return Inertia::render('projects/Index', [
        'projects' => ProjectResource::collection($projects)->resolve(),
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
                return Inertia::render('projects/ProjectDetails', [
        'project' => (new ProjectResource($project))->resolve(),
         'meta' => [
            'title' => $project->name . ' | Lighting & Camera Services',
            'description' => Str::limit($project->description, 160),
            'image' => asset($project->main_image ?? 'default-project.jpg'),
            'url' => url()->current(),
        ],
       
    ]);
                
            }

            return response()->json([
                'message' => 'Project not found'
            ], 404);
            }
    }
