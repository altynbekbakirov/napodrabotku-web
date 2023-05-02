<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use App\Models\District;
use App\Models\EducationType;
use App\Models\JobSphere;
use App\Models\JobType;
use App\Models\Opportunity;
use App\Models\Region;
use App\Models\SocialOrientation;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserCV;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserVacancy;
use App\Models\Vacancy;
use App\Models\Skillset;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function index()
    {
        $model = User::query()->get();
        return response()->json($model);
    }

    public function show(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where("password", $token)->firstOrFail();

        if ($user) {
            if($user->region && $user->district) {
                $region = Region::find($user->region);
                $district = District::find($user->district);

                $user->region = $region->getName($request->lang);
                $user->district = $district->getName($request->lang);
            } else {
                $user->region = '';
                $user->district = '';
            }

            if($user->job_type) {
                $job_type = JobType::find($user->job_type);
                $user->job_type = $job_type->getName($request->lang);
            } else {
                $user->job_type = '';
            }

            if($user->opportunity) {
                $opportunity = Opportunity::find($user->opportunity);
                $user->opportunity = $opportunity->getName($request->lang);
            } else {
                $user->opportunity = '';
            }

            if($user->job_sphere) {
                $job_sphere = JobSphere::find($user->job_sphere);
                $user->job_sphere = $job_sphere->getName($request->lang);
            } else {
                $user->job_sphere = '';
            }

            if($user->department) {
                $department = Department::find($user->department);
                $user->department = $department->getName($request->lang);
            } else {
                $user->department = '';
            }

            if($user->social_orientation) {
                $social_orientation = SocialOrientation::find($user->social_orientation);
                $user->social_orientation = $social_orientation->getName($request->lang);
            } else {
                $user->social_orientation = '';
            }

            return response($user);
        }
        return response('token is not valid');
    }

    protected function avatar(Request $request)
    {
        $vacancy_id = $request->vacancy_id;
        $vacancy = Vacancy:: findOrFail($vacancy_id);
        if($vacancy){
            $user = User::findOrFail($vacancy->company_id);
            if ($user->avatar) {
                //get content of image
                return $user->avatar;
            } else {
                return "company doesn't have image";
            }
        }
        else
            return "vacancy doesn't exists";
    }

    protected function checkUserEmail(Request $request)
    {
        $email = $request->email;
        if($email){
            $count = User::where('email', $email)->count();
            if($count>0)
                return "true";
            else
                return "false";
        }
        else
            return 'email not found';
    }

    protected function checkUserCv(Request $request)
    {
        $user_id = $request->user_id;
        if($user_id){
            $user_cv = UserCV::where('user_id', $user_id)->firstOrFail();
            if($user_cv->job_title)
                return "true";
            else
                return "false";
        }
        else
            return 'user_id not found';
    }

    protected function getCompanySubmittedUserCvs(Request $request, $company_id)
    {
        if($company_id){
            $vacancy_ids =Vacancy::where('company_id', $company_id)->pluck('id')->toArray();
            $submitted_user_vacancies = UserVacancy::whereIn("vacancy_id", $vacancy_ids)->where("type", 'SUBMITTED')->orderBy('id', 'desc')->get();
            $result = [];
            foreach ($submitted_user_vacancies as $submitted_user_vacancy) {

                array_push($result, [
                    'vacancy_name' => $submitted_user_vacancy->vacancy->name,
                    'id' => $submitted_user_vacancy->user->id,
                    'user_vacancy_id' => $submitted_user_vacancy->id,
                    'name' => $submitted_user_vacancy->user->name,
                    'lastname' => $submitted_user_vacancy->user->lastname,
                    'email' => $submitted_user_vacancy->user->email,
                    'phone_number' => $submitted_user_vacancy->user->phone_number,
                    'avatar' => $submitted_user_vacancy->user->avatar,
                    'birth_date' => $submitted_user_vacancy->user->birth_date,
                    'job_title' => UserCv::where('user_id',$submitted_user_vacancy->user->id)->first()->job_title,
                    'experience_year' => UserCv::where('user_id',$submitted_user_vacancy->user->id)->first()->experience_year,
                    'recruited' => $submitted_user_vacancy->recruited
                ]);
            }
            return $result;
        }
        else{
            return 'company id doesnt exist';
        }
    }

    protected function getUserFullInfo(Request $request, $user_id)
    {
        if($user_id){
            $user = User::find($user_id);
            if($user){
                $user_cv = UserCV::where('user_id', $user_id)->firstOrFail();
                if($user_cv){
                    $user_experiences = [];
                    foreach (UserExperience::where('user_cv_id', $user_cv->id)->get() as $model) {
                        array_push($user_experiences, [
                            'id' => $model->id,
                            'job_title' => $model->job_title,
                            'start_date' => $model->start_date,
                            'end_date' => $model->end_date,
                            'organization_name' => $model->organization_name,
                            'description' => $model->description,
                        ]);
                    }

                    $user_courses = [];
                    foreach (UserCourse::where('user_cv_id', $user_cv->id)->get() as $model) {
                        array_push($user_courses, [
                            'id' => $model->id,
                            'name' => $model->name,
                            'organization_name' => $model->organization_name,
                            'end_year' => $model->end_year,
                            'duration' => $model->duration,
                        ]);
                    }

                    $user_educations = [];
                    foreach (UserEducation::where('user_cv_id', $user_cv->id)->get() as $model) {
                        array_push($user_educations, [
                            'id' => $model->id,
                            'title' => $model->title,
                            'faculty' => $model->faculty,
                            'speciality' => $model->speciality,
                            'type' => EducationType::findOrFail($model->type_id)->name,
                            'end_year' => $model->end_year,
                        ]);
                    }

                    $user_skills = DB::table('user_skills')->where('user_id', $user->id)->where('type', 1)->get();
                    $skills = [];
                    if($user_skills){
                        foreach ($user_skills as $model) {
                            $skill = Skillset::find($model->skill_id);
                            $skills[] = $skill->name_ru;
                        }
                    }

                    $user_skills2 = DB::table('user_skills')->where('user_id', $user->id)->where('type', 2)->get();
                    $skills2 = [];
                    if($user_skills2){
                        foreach ($user_skills2 as $model2) {
                            $skill2 = Skillset::find($model2->skill_id);
                            $skills2[] = $skill2->name_ru;
                        }
                    }

                    if($user->opportunity) {
                        $opportunity = Opportunity::find($user->opportunity);
                        $user->opportunity = $opportunity->getName("ru");
                    } else {
                        $user->opportunity = '';
                    }

                    if($user->job_sphere) {
                        $job_sphere = JobSphere::find($user->job_sphere);
                        $user->job_sphere = $job_sphere->getName("ru");
                    } else {
                        $user->job_sphere = '';
                    }

                    return response()->json([
                        'id' => $user->id,
                        'name' => $user->name,
                        'surname_name' => $user->lastname,
                        'email' => $user->email,
                        'phone_number' => $user->phone_number,
                        'avatar' => $user->avatar,
                        'birth_date' => $user->birth_date,
                        'linkedin' => $user->linkedin,
                        'is_migrant' => $user->is_migrant,
                        'job_title' => $user_cv->job_title,
                        'experience_year' => $user_cv->experience_year,
                        'attachment' => $user_cv->attachment,
                        'educations' => $user_educations,
                        'courses' => $user_courses,
                        'experiences' => $user_experiences,
                        'opportunity' => $user->opportunity,
                        'job_sphere' => $user->job_sphere,
                        'skills' => $skills,
                        'skills2' => $skills2,
                    ]);
                }
                else{
                    return 'user doesnt have cv';
                }
            }
            else{
                return 'user doesnt exist';
            }
        }
        else{
            return 'company id doesnt exist';
        }
    }

    public function store(Request $request)
    {
        $lang = $request->lang ? $request->lang : 'ru';

        if (User::where('email', $request->email)->count() == 0) {

            if($lang == 'ru'){
                $region = Region::where('nameRu', $request->region)->first();
                $district = District::where('nameRu', $request->district)->first();
                $job_type = JobType::where('name_ru', $request->job_type)->first();
            } else {
                $region = Region::where('nameKg', $request->region)->first();
                $district = District::where('nameKg', $request->district)->first();
                $job_type = JobType::where('name', $request->job_type)->first();
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'birth_date' => $request->birth_date,
                'type' => $request->type,
                'address' => $request->address,
                'active' => true,
                'phone_number' => $request->phone_number,
                'linkedin' => $request->linkedin,
                'is_migrant' => $request->is_migrant == '1',
                'gender' => $request->gender == '1',
                'region' => $region ? $region->id : null,
                'district' => $district ? $district->id : null,
                'job_type' => $job_type ? $job_type->id : null,
                'contact_person_fullname' => $request->contact_person_fullname,
                'contact_person_position' => $request->contact_person_position,
                'is_product_lab_user' => $request->is_product_lab_user,
            ]);

            // create empty cv
            if($user && $user->type == 'USER') {
                UserCV::create([
                    'user_id' => $user->id
                ]);
            }

            if($request->hasFile('avatar')){

                $file = $request->file('avatar');

                $dir  = 'assets/media/users/';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $name = Str::slug($user->name, '-').'.'.$file->getClientOriginalExtension();

                Image::make($file)->fit(400, 400)->save($dir.$name, 75);

                $user->avatar = $dir.$name;
            }

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            try {
                $user->save();
                return response()->json([
                    'id' => $user->id,
                    'token' => $user->password,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'user_type' => $user->type,
                    'message' => 'Successfully created user!',
                    'status' => 200,
                    'gender' => $user->gender,
                    'region' => $region ? $region->getName($lang) : 0,
                    'district' => $district ? $district->getName($lang) : 0,
                    'job_type' => $job_type ? $job_type->getName($lang) : 0,
                    'contact_person_fullname' => $user->contact_person_fullname,
                    'contact_person_position' => $user->contact_person_position,
                ], 200);
            } catch (QueryException $e) {
                return response()->json([
                    'id' => null,
                    'token' => null,
                    'message' => 'error!',
                    'status' => 999,
                ]);
            }
        }
        return response()->json([
            'id' => null,
            'token' => null,
            'message' => 'user exist!',
            'status' => 999,
        ]);
    }

    public function update1(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user) {

            if($request->hasFile('avatar')){

                if($user->avatar) @unlink($user->avatar);

                $file = $request->file('avatar');

                $dir  = 'assets/media/users/';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $name = Str::slug($user->name, '-').'.'.$file->getClientOriginalExtension();

                Image::make($file)->fit(400, 400)->save($dir.$name, 75);

                $user->avatar = $dir.$name;
            }

            $region = Region::where('nameRu', $request->region)->orWhere('nameKg', $request->region)->first();
            $district = District::where('nameRu', $request->district)->orWhere('nameKg', $request->district)->first();
            $job_sphere = JobSphere::where('name_ru', $request->job_sphere)->orWhere('name', $request->job_sphere)->first();
            $department = Department::where('name_ru', $request->department)->orWhere('name', $request->department)->first();
            $social_orientation = SocialOrientation::where('name_ru', $request->social_orientation)->orWhere('name', $request->social_orientation)->first();

            $user ->update([
                'name' => $request->name,
                'email' => $request->email,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'linkedin' => $request->linkedin,
                'is_migrant' => $request->is_migrant,
                'gender' => $request->gender == '1',
                'region' => $region ? $region->id : null,
                'district' => $district ? $district->id : null,
                'contact_person_fullname' => $request->contact_person_fullname,
                'contact_person_position' => $request->contact_person_position,
                'job_sphere' => $job_sphere ? $job_sphere->id : 0,
                'department' => $department ? $department->id : 0,
                'social_orientation' => $social_orientation ? $social_orientation->id : 0,
            ]);

            try {
                $user->save();
                return response()->json([
                    'id' => $user->id,
                    'token' => $user->password,
                    'avatar' => $user->avatar,
                    'message' => 'Successfully updated user!'
                ], 201);
            } catch (QueryException $e) {
                return response()->json([
                    'id' => null,
                    'token' => null,
                    'message' => 'error!',
                    'status' => 999,
                ]);
            }
        }
        return response()->json([
            'id' => null,
            'token' => null,
            'message' => 'user doesn\'t exists!',
            'status' => 999,
        ]);
    }

    public function saveFilters(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user) {

            $user ->update([
                'filter_region' => $request->regions,
                'filter_activity' => $request->activities,
                'filter_type' => $request->types,
                'filter_busyness' => $request->busyness,
                'filter_schedule' => $request->schedules,
            ]);
            try {
                $user->save();
                return response()->json([
                    'id' => $user->id,
                    'token' => $user->password,
                    'message' => 'Successfully saved filters!'
                ], 201);
            } catch (QueryException $e) {
                return response()->json([
                    'id' => null,
                    'token' => null,
                    'message' => 'error!',
                    'status' => 999,
                ]);
            }
        }
        return response()->json([
            'id' => null,
            'token' => null,
            'message' => 'user doesn\'t exists!',
            'status' => 999,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $user = Patient::findOrFail($id);
        if ($request->header('token') == $user->password) {
            $user->delete();
        }
        return response('deleted');
    }

    public function getFilters(Request $request, $id, $model)
    {
        $result = [];

        $user = User::findOrFail($id);
        if($user) {
            if($model == 'regions') $result = $user->filter_region;
            if($model == 'activities') $result = $user->filter_activity;
            if($model == 'types') $result = $user->filter_type;
            if($model == 'busyness') $result = $user->filter_busyness;
            if($model == 'schedules') $result = $user->filter_schedule;
            if($model == 'districts') $result = $user->filter_district;
        }

        return $result;
    }

    public function resetSettings(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        if ($user) {
            $user->filter_region = null;
            $user->filter_district = null;
            $user->filter_activity = null;
            $user->filter_type = null;
            $user->filter_busyness = null;
            $user->filter_schedule = null;

            $user_vacancies = UserVacancy::where('user_id', $user->id)->where('type', '<>', 'SUBMITTED')->delete();

            return response()->json('OK');
        }
        return response()->json('user id does not exist');
    }

    public function getUserSkills(Request $request)
    {
        $type = $request->type;

        $result = [];

        if($request->email) {
            $user = User::where('email', $request->email)->first();

            if($user){

                if($type) {
                    $user_skills = DB::table('user_skills')->where('user_id', $user->id)->where('type', $type)->get();
                } else {
                    $user_skills = DB::table('user_skills')->where('user_id', $user->id)->get();
                }

                foreach ($user_skills as $user_skill){

                    $skill = Skillset::find($user_skill->skill_id);

                    if($skill){
                        $result[] = [
                            'id'=> $skill->id,
                            'name'=> $skill->getName("ru"),
                            'category_id' => $skill->skillset_category_id,
                        ];
                    }
                }

                return json_encode($result, JSON_UNESCAPED_UNICODE);

            }

        }

        return response()->json([
            'id' => null,
            'token' => null,
            'message' => 'user doesn\'t exists!',
            'status' => 999,
        ]);

    }

    public function saveUserSkills(Request $request)
    {
        $lang = $request->lang ? $request->lang : 'ru';
        $tag = array();

        $user = User::find($request->user_id);
        $type = $request->type ? $request->type : 1;

        if(count($request->user_skills) > 0) {

            foreach($request->user_skills as $skill_name){

                $skill = Skillset::where('name_ru', $skill_name)->first();

                if($skill){

                    $category_skills = Skillset::where('skillset_category_id', $skill->skillset_category_id)->get();

                    foreach ($category_skills as $category_skill) {
                        if(!in_array($category_skill->name_ru, $request->user_skills)){
                            DB::table('user_skills')->where('user_id', $user->id)->where('skill_id', $category_skill->id)->where('type', $type)->delete();
                        }
                        if($category_skill->id == $skill->id){
                            DB::table('user_skills')->where('user_id', $user->id)->where('skill_id', $category_skill->id)->where('type', $type)->delete();
                        }
                    }

                    DB::table('user_skills')->insert([
                        'user_id' => $request->user_id,
                        'skill_id' => $skill->id,
                        'type' => $type
                    ]);

                }
            }
        }

        try {
            return response()->json([
                'id' => $user->id,
                'message' => 'Successfully added user skills!'
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'id' => null,
                'token' => null,
                'message' => 'error!',
                'status' => 999,
            ]);
        }
        return response()->json([
            'id' => null,
            'token' => null,
            'message' => 'user exist!',
            'status' => 999,
        ]);
    }

    public function saveJobSphere(Request $request)
    {
        $user = User::find($request->id);

        if($user){

            if($request->job_sphere){
                $job_sphere = JobSphere::where('name_ru', $request->job_sphere)->first();

                $user->job_sphere = $job_sphere->id;
                $user->save();

                return response()->json([
                    'id' => $user->id,
                    'message' => 'Successfully updated user!'
                ], 200);
            }

        }
        return response()->json([
            'id' => null,
            'token' => null,
            'message' => 'Something went wrong!',
            'status' => 999,
        ]);
    }

    public function saveOpportunity(Request $request)
    {
        $user = User::find($request->id);

        if($user){

            if($request->opportunity){
                $opportunity = Opportunity::where('name_ru', $request->opportunity)->first();

                if($opportunity){
                    $user->opportunity = $opportunity->id;
                    $user->save();

                    return response()->json([
                        'id' => $user->id,
                        'message' => 'Successfully updated user!'
                    ], 200);
                }
            }

        }
        return response()->json([
            'id' => null,
            'token' => null,
            'message' => 'Something went wrong!',
            'status' => 999,
        ]);
    }

    public function deleteAccount(Request $request, $user_id)
    {
        $user = User::findOrFail($request->user_id);

        if($user) {
            try {
                $user_vacancies = UserVacancy::where('user_id', $user->id)->delete();
                $user_skills = DB::table('user_skills')->where('user_id', $user->id)->delete();
                $user_email_codes = DB::table('user_email_codes')->where('user_id', $user->id)->delete();
    
                $user_cv_id = UserCV::where('user_id', $user->id)->pluck('id');
    
                $user_experiens = UserExperience::whereIn('user_cv_id', $user_cv_id)->delete();

                $user_education = UserEducation::whereIn('user_cv_id', $user_cv_id)->delete();

                $user_courses = DB::table('user_courses')->whereIn('user_cv_id', $user_cv_id)->delete();
    
                $user_cvs = UserCV::where('user_id', $user->id)->delete();
                $user->delete();

                return response()->json([
                    'message' => 'OK'
                ], 200);
    
            } catch (QueryException $e) {
                return response()->json([
                    'id' => null,
                    'token' => null,
                    'message' => 'error!',
                    'status' => 999,
                ]);
            }
        } else {
            return response()->json([
                'id' => null,
                'token' => null,
                'message' => 'user doesn\'t exists!',
                'status' => 999,
            ]);
        }
    }

    public function setUserVacancyRecruit(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $user_vacancy = UserVacancy::findOrFail($request->user_vacancy_id);

        if($user) {
            if($user_vacancy) {
                $user_vacancy->recruited = $request->recruited;
                // $user_vacancy->update([
                //     'recruited' => $request->recruited,
                // ]);

                $user_vacancy->update();
                return response()->json([
                    'message' => 'OK'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Vacancy does not exist',
                    'status' => 400,
                ]);
            }
        } else {
            return response()->json([
                'id' => null,
                'token' => null,
                'message' => 'User does not exist',
                'status' => 400,
            ]);
        }
    }

    public function getUserVacancyRecruit(Request $request, $vacancy_id)
    {
        $token = $request->header('Authorization');
        $user = User::where("password", $token)->firstOrFail();

        $user_vacancy = UserVacancy::where('user_id',  $user->id)->where('type', 'SUBMITTED')->where('vacancy_id', $vacancy_id)->first();

        if($user) {
            if($user_vacancy) {
                return response()->json([
                    'recruited' => $user_vacancy->recruited,
                    'message' => 'OK'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Submitted vacancy does not exist',
                    'status' => 400,
                ]);
            }
        } else {
            return response()->json([
                'id' => null,
                'token' => null,
                'message' => 'User does not exist',
                'status' => 400,
            ]);
        }
    }

}
