<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SlideResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TeamResource;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\TestimonialResource;

use App\Models\Testimonial;
use App\Models\Slide;
use App\Models\Service;
use App\Models\Project;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function sliders()
    {
        Log::info('sliders:',[SlideResource::collection(Slide::all())->resolve()]);
        return SlideResource::collection(Slide::all())->resolve();
    }

    public function services()
    {

        return ServiceResource::collection(Service::all());
    }

      

    public function team()
    {
        return TeamResource::collection(TeamMember::all());
    }

    public function testimonials()
    {
        return TestimonialResource::collection(Testimonial::where('checked',true)->get())->resolve();
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
