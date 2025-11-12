<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SlideResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TeamResource;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\TestimonialResource;
use App\Http\Resources\ContactResource;
use App\Models\Testimonial;
use App\Models\Contact;
use App\Models\Slide;
use App\Models\Service;
use App\Models\Project;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class HomeController extends Controller
{
    

    public function index()
    {
        
         return Inertia::render('home/Index', [
        'sliders' => SlideResource::collection(Slide::all())->resolve(),
        'services' => ServiceResource::collection(Service::all())->resolve(),
        'latestProjects' => ProjectResource::collection(
            Project::latest()->take(6)->get()
        )->resolve(),
        'contact' => (new ContactResource(Contact::first()))->resolve(),
        'testimonials' => TestimonialResource::collection(Testimonial::where('checked', true)->get())->resolve(),
 
       
    ]);
    }

   




    // store
     public function storeTestimonial(Request $request)
    {
        try {
            //code...
        
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'company'  => 'nullable|string|max:255',
            'content'  => 'required|string',
        ]);

        Log::info('data:',[$data]);

        $testimonial = Testimonial::create($data);

        return new TestimonialResource($testimonial);

        } catch (\Throwable $th) {
               Log::info('error:',[$th]);
        }
    }
}
