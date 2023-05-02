<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobSphere;
use \App\Models\JobType;
use \App\Models\Department;
use \App\Models\SocialOrientation;
use \App\Models\Opportunity;
use \App\Models\IntershipLanguage;
use \App\Models\OpportunityType;
use \App\Models\OpportunityDuration;
use \App\Models\RecommendationLetterType;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    public function index(Request $request)
    {
        return "Just Do It";
    }

    public function job_spheres(Request $request) {
        $result = [];
        foreach (JobSphere::all() as $item){
            array_push($result, [
                'id'=> $item->id,
                'name'=> $item->getName($request->lang)
            ]);
        }
        return $result;
    }

    public function departments(Request $request) {
        $result = [];

        if($request->job_sphere){
            $job_sphere = JobSphere::where('name_ru', $request->job_sphere)->orWhere('name', $request->job_sphere)->first();

            foreach (Department::where('job_sphere_id', $job_sphere->id)->get() as $item){
                array_push($result, [
                    'id'=> $item->id,
                    'name'=> $item->getName($request->lang)
                ]);
            }
        } else {
            foreach (Department::all() as $item){
                array_push($result, [
                    'id'=> $item->id,
                    'name'=> $item->getName($request->lang)
                ]);
            }
        }

        return $result;
    }

    public function social_orientations(Request $request) {
        $result = [];
        foreach (SocialOrientation::all() as $item){
            array_push($result, [
                'id'=> $item->id,
                'name'=> $item->getName($request->lang)
            ]);
        }
        return $result;
    }

    public function opportunities(Request $request) {
        $result = [];
        foreach (Opportunity::all() as $item) {
            array_push($result, [
                'id'=> $item->id,
                'name'=> $item->getName($request->lang)
            ]);
        }
        return $result;
    }

    public function intership_languages(Request $request) {
        $result = [];
        foreach (IntershipLanguage::all() as $item) {
            array_push($result, [
                'id'=> $item->id,
                'name'=> $item->getName($request->lang)
            ]);
        }
        return $result;
    }

    public function opportunity_types(Request $request) {
        $result = [];
        foreach (OpportunityType::all() as $item) {
            array_push($result, [
                'id'=> $item->id,
                'name'=> $item->getName($request->lang)
            ]);
        }
        return $result;
    }

    public function opportunity_durations(Request $request) {
        $result = [];
        foreach (OpportunityDuration::all() as $item) {
            array_push($result, [
                'id'=> $item->id,
                'name'=> $item->getName($request->lang)
            ]);
        }
        return $result;
    }

    public function recommendation_letter_types(Request $request) {
        $result = [];
        foreach (RecommendationLetterType::all() as $item) {
            array_push($result, [
                'id'=> $item->id,
                'name'=> $item->getName($request->lang)
            ]);
        }
        return $result;
    }
}
