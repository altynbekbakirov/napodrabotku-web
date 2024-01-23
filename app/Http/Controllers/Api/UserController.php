<?php

namespace App\Http\Controllers\Api;

use App\Models\Busyness;
use App\Models\Chat;
use App\Models\Department;
use App\Models\District;
use App\Models\EducationType;
use App\Models\JobSphere;
use App\Models\JobType;
use App\Models\Opportunity;
use App\Models\Region;
use App\Models\Country;
use App\Models\Schedule;
use App\Models\SocialOrientation;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserCourse;
use App\Models\UserCV;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserVacancy;
use App\Models\Vacancy;
use App\Models\Skillset;
use App\Models\VacancyType;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where("password", $token)->firstOrFail();
        $lang = $request->lang;

        $time_type = $request->type;
        $job_type_ids = $request->job_type_ids;
        $schedule_ids = $request->schedule_ids;
        $busyness_ids = $request->busyness_ids;
        $type_ids = $request->type_ids;
        $region_ids = $request->region_ids;
        $district_ids = $request->district_ids;
        $gender_ids = $request->gender_ids;
        $country_ids = $request->country_ids;

        if (!$job_type_ids) {
            $job_type_ids = [];
            foreach (JobType::all() as $model) {
                $job_type_ids[] = $model->id;
            }
        }
        if (!$busyness_ids) {
            $busyness_ids = [];
            foreach (Busyness::all() as $model) {
                $busyness_ids[] = $model->id;
            }
        }
        if (!$schedule_ids) {
            $schedule_ids = [];
            foreach (Schedule::all() as $model) {
                $schedule_ids[] = $model->id;
            }
        }
        if (!$type_ids) {
            $type_ids = [];
            foreach (VacancyType::all() as $model) {
                $type_ids[] = $model->id;
            }
        }
        if (!$region_ids || $region_ids[0] == null) {
            $region_ids = [];
            foreach (Region::all() as $model) {
                $region_ids[] = $model->id;
            }
        }
        if (!$district_ids) {
            $district_ids = [];
            foreach (District::all() as $model) {
                $district_ids[] = $model->id;
            }
        }
        if (!$gender_ids) {
            $gender_ids = ['male', 'female'];
        }
        if (!$country_ids) {
            $country_ids = [];
            foreach (Country::all() as $model) {
                $country_ids[] = $model->id;
            }
        }

        if($user) {
            $vacancies = Vacancy::where('company_id', $user->id)->where('status', 'active')->pluck('id')->toArray();
            $invited_users = UserCompany::where("company_id", $user->id)->whereIn('vacancy_id', $vacancies)->whereIn('type', ['INVITED'])->orderBy('created_at', 'desc')->get();
            $banned_users = [];
            $vacancies_invited = 0;
            foreach ($invited_users as $invited_user){
                foreach ($vacancies as $vacancy){
                    if($vacancy == $invited_user->vacancy_id){
                        $vacancies_invited++;
                    }
                }
                if($vacancies_invited == count($vacancies)){
                    $banned_users[] = $invited_user->id;
                }
            }
            $users = User::where('type', 'USER')->whereNotIn('id', $banned_users);

            $specificDate = strtotime('2000-1-1');
            $specificDate = date("Y-m-d H:i:s", $specificDate);

            if($time_type == 'day'){
                $date = new DateTime('-1 day');
                $specificDate = $date->format('Y-m-d H:i:s');
            }
            else if($time_type == 'week'){
                $date = new DateTime('-1 week');
                $specificDate = $date->format('Y-m-d H:i:s');
            }
            else if($time_type == 'month'){
                $date = new DateTime('-1 month');
                $specificDate = $date->format('Y-m-d H:i:s');
            }

            if($request->type_ids){
                $users = $users
                    ->whereIn('vacancy_types', $request->type_ids);
            }

            if($request->schedule_ids){
                $users = $users
                    ->whereIn('schedules', $request->schedule_ids);
            }

            if($request->busyness_ids){
                $users = $users
                    ->whereIn('business', $request->busyness_ids);
            }

            $users = $users
//                ->whereIn('job_type', $job_type_ids)
//                ->whereIn('business', $busyness_ids)
//                ->whereIn('vacancy_types', $type_ids)
//                ->whereIn('schedules', $schedule_ids)
                ->whereIn('region', $region_ids);

            $users = $users
                ->whereDate('created_at', '>', $specificDate)->get();
        } else {
            $users = User::where('type', 'USER')->get();
        }

        foreach ($users as $user){
            $user->vacancy_type = $user->getVacancyType ? $user->getVacancyType->getName($lang) : null;
            $user->business = $user->getBusiness ? $user->getBusiness->getName($lang) : null;
            $user->region = $user->getRegion ? $user->getRegion->getName($lang) : null;
            $user->district = $user->getDistrict ? $user->getDistrict->getName($lang) : null;
            $user->status_text = $user->getStatusPlain();
            $user->status = $user->active;
            $user->currency = $user->getCurrency ? $user->getCurrency->code : '';
            $user->age = $user->birth_date ? $user->getAge() : '';
            $user->vacancy_types = $user->vacancy_types ? VacancyType::whereIn('id', $user->vacancy_types)->pluck('name_ru')->toArray() : null;
            $user->schedules = $user->schedules ? Schedule::whereIn('id', $user->schedules)->pluck('name_ru')->toArray() : null;
        }

        return response()->json($users);
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
            $vacancy_ids = Vacancy::where('company_id', $company_id)->pluck('id')->toArray();
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

        $region = $district = $job_type = $citizen = null;

        if (User::where('phone_number', $request->phone_number)->count() == 0) {

            if($request->type == 'USER'){
                if($lang == 'ru'){
                    $region = Region::where('nameRu', $request->region)->first();
                    $district = District::where('nameRu', $request->district)->first();
                    $job_type = JobType::where('name_ru', $request->job_type)->first();
                    $citizen = Country::where('id', $region->country)->first();
                } else {
                    $region = Region::where('nameKg', $request->region)->first();
                    $district = District::where('nameKg', $request->district)->first();
                    $job_type = JobType::where('name', $request->job_type)->first();
                    $citizen = Country::where('id', $region->country)->first();
                }
            }

            $user = User::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'birth_date' => $request->birth_date,
                'type' => $request->type,
                'address' => $request->address,
                'active' => true,
                'phone_number' => $request->phone_number,
                'linkedin' => $request->linkedin,
                'is_migrant' => $request->is_migrant == '1',
                'gender' => strtolower($request->gender),
                'region' => $region ? $region->id : null,
                'citizen' => $citizen ? $citizen->id : null,
                'district' => $district ? $district->id : null,
                'job_type' => $job_type ? $job_type->id : null,
                'contact_person_fullname' => $request->contact_person_fullname,
                'contact_person_position' => $request->contact_person_position,
                'is_product_lab_user' => 0,
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
                    'phone_number' => $user->phone_number,
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
            'message' => 'user_exist',
            'status' => 999,
        ]);
    }

    public function update1(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user) {

            if($request->file('avatar')){

                if($user->avatar) @unlink($user->avatar);

                $file = $request->file('avatar');

                $dir  = 'assets/media/users/';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $name = Str::slug($user->name, '-').'-'.$user->id.'.'.$file->getClientOriginalExtension();

                $imageResize = Image::make($file);
                $imageResize->orientate()
                    ->fit(400, 400, function ($constraint) {
                        $constraint->upsize();
                    })
                    ->save($dir.$name, 75);

//                Image::make($file)->fit(400, 400)->save($dir.$name, 75);

                $user->avatar = $dir.$name;
            }

            $region = Region::where('nameRu', $request->region)->orWhere('nameKg', $request->region)->first();
            $district = District::where('nameRu', $request->district)->orWhere('nameKg', $request->district)->first();
            $job_sphere = JobSphere::where('name_ru', $request->job_sphere)->orWhere('name', $request->job_sphere)->first();
            $department = Department::where('name_ru', $request->department)->orWhere('name', $request->department)->first();
            $social_orientation = SocialOrientation::where('name_ru', $request->social_orientation)->orWhere('name', $request->social_orientation)->first();

            $user->update([
                'name' => $request->name,
                'lastname' => $request->lastname,
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
                'description' => $request->description,
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
        $user = User::findOrFail($id);
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
            if($model == 'regions') $result = $user->filter_region ?? [];
            if($model == 'activities') $result = $user->filter_activity ?? [];
            if($model == 'types') $result = $user->filter_type ?? [];
            if($model == 'busyness') $result = $user->filter_busyness ?? [];
            if($model == 'schedules') $result = $user->filter_schedule ?? [];
            if($model == 'districts') $result = $user->filter_district ?? [];
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

    public function resetDislikedVacancies(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where("password", $token)->firstOrFail();

        if ($user) {
            UserVacancy::where('user_id', $user->id)->where('type', 'DISLIKED')->delete();
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

    public function userCompany(Request $request)
    {
        $type = $request->type;
        $token = $request->header('Authorization');
        $user_id = $request->user_id;
        $vacancy_id = $request->vacancy_id;

        $company = User::where("password", $token)->firstOrFail();

        if($company){

            if($type == 'SUBMITTED'){
                $existing_user_vacancy = UserVacancy::where("user_id", $user_id)
                    ->where("vacancy_id", $vacancy_id)
                    ->where("type", "SUBMITTED")
                    ->first();

                if($existing_user_vacancy) {
                    $existing_user_vacancy ->update(['type' => 'DECLINED']);
                    $existing_user_vacancy->save();
                }
            } else {

                $existing_user_company = UserCompany::where("user_id", $user_id)
                    ->where("vacancy_id", $vacancy_id)
                    ->first();

                $show_phone = UserCompany::where('user_id', $user_id)->where('show_phone', 1)->first();

                if($existing_user_company) {
                    if($show_phone) $existing_user_company->show_phone = 1;
                    $existing_user_company->type = $type;
                    $existing_user_company->read = 0;
                    $existing_user_company->save();
                } else {
                    $user_company = new UserCompany;
                    $user_company->user_id = $user_id;
                    $user_company->company_id = $company->id;
                    $user_company->type = $type;
                    if($show_phone) $user_company->show_phone = 1;
                    $user_company->save();
                }
            }

            return 'OK';
        } else {
            return "token is not valid";
        }

    }

    public function userCompanyDelete(Request $request)
    {
        $type = $request->type;
        $token = $request->header('Authorization');
        $user_id = $request->user_id;

        $company = User::where("password", $token)->firstOrFail();

        if($company){
            $existing_user_company = UserCompany::where("user_id", $user_id)
                ->where("company_id", $company->id)
                ->where("type", "LIKED")
                ->first();
            if($existing_user_company) {
                $existing_user_company ->update([
                    'type' => $type,
                ]);
                $existing_user_company->save();
            } else{
                return "no such user_company";
            }
            return 'OK';
        } else{
            return "token is not valid";
        }

    }

    protected function userCompanyLikedUsers(Request $request, $company_id)
    {
        $lang = 'ru';

        if($company_id){
            $liked_users = UserCompany::where("company_id", $company_id)->where("type", 'LIKED')->orderBy('id', 'desc')->pluck('user_id')->toArray();
            $users = User::where('type', 'USER')->whereIn('id', $liked_users)->get();

            foreach ($users as $user){
                $user->vacancy_type = $user->getVacancyType ? $user->getVacancyType->getName($lang) : null;
                $user->business = $user->getBusiness ? $user->getBusiness->getName($lang) : null;
                $user->region = $user->getRegion ? $user->getRegion->getName($lang) : null;
                $user->district = $user->getDistrict ? $user->getDistrict->getName($lang) : null;
                $user->status_text = $user->getStatusPlain();
                $user->status = $user->active;
                $user->currency = $user->getCurrency ? $user->getCurrency->code : '';
                $user->vacancy_types = $user->vacancy_types ? VacancyType::whereIn('id', $user->vacancy_types)->pluck('name_ru')->toArray() : null;
                $user->schedules = $user->schedules ? Schedule::whereIn('id', $user->schedules)->pluck('name_ru')->toArray() : null;
            }

            return response()->json($users);
        }
        else{
            return 'company id doesnt exist';
        }
    }

    public function getUsersByType(Request $request, $type)
    {
        $lang = $request->lang;
        $token = $request->header('Authorization');
        $user = User::where("password", $token)->firstOrFail();
        if($user){
            $type = $request->type;

            $response_type = '';

            if($type == 'ALL'){
                $result1 = UserCompany::whereNotNull('vacancy_id')->whereIn("type", ['INVITED', 'DECLINED'])
                    ->where('company_id', $user->id)
                    ->orderBy('created_at', 'desc')->orderBy('read')->get()
                    ->mapToGroups(function ($item, $key) {
                        return [$item['vacancy_id'] => [
                            'user_id' => $item['user_id'],
                            'type' => $item['type'],
                            'read' => $item['read'],
                            'created_at' => $item['created_at'],
                        ]];
                    })->toArray();

                $companyVacancies = Vacancy::where('company_id', $user->id)->orderBy('created_at', 'desc')->pluck('id')->toArray();
                $result2 = UserVacancy::whereIn('type', ['SUBMITTED'])
                    ->whereIn('vacancy_id', $companyVacancies)
                    ->orderBy('created_at', 'desc')->orderBy('read')->get()
                    ->mapToGroups(function ($item, $key) {
                        return [$item['vacancy_id'] => [
                            'user_id' => $item['user_id'],
                            'type' => $item['type'],
                            'read' => $item['read'],
                            'created_at' => $item['created_at'],
                        ]];
                    })
                    ->toArray();
//                dd($result1, $result2);

//                $result = Arr::collapse([$result1, $result2]);
                $result = $result1 + $result2;
            } elseif ($type == 'INVITED') {
                $result = UserCompany::whereNotNull('vacancy_id')->whereIn("type", ['INVITED', 'DECLINED'])
                    ->where('company_id', $user->id)
                    ->orderBy('created_at', 'desc')->orderBy('read')->get()
                    ->mapToGroups(function ($item, $key) {
                        return [$item['vacancy_id'] => [
                            'user_id' => $item['user_id'],
                            'type' => $item['type'],
                            'read' => $item['read'],
                            'created_at' => $item['created_at'],
                        ]];
                    })->toArray();
            } else {
                $companyVacancies = Vacancy::where('company_id', $user->id)->pluck('id')->toArray();
                $result = UserVacancy::where('type', $type)
                    ->whereIn('vacancy_id', $companyVacancies)
                    ->orderBy('created_at', 'desc')->orderBy('read')->get()
                    ->mapToGroups(function ($item, $key) {
                        return [$item['vacancy_id'] => [
                            'user_id' => $item['user_id'],
                            'type' => $item['type'],
                            'read' => $item['read'],
                            'created_at' => $item['created_at'],
                        ]];
                    })->toArray();
            }

            $temp = collect();
            foreach ($result as $key=>$row){
                foreach ($row as $single){
                    $single['vacancy_id'] = $key;
                    $temp->push($single);
                }
            }
            $users = [];

//            foreach ($result as $key=>$row){

                foreach ($temp->sortByDesc('created_at') as $item){
                    $user = User::findOrFail($item['user_id']);
                    $vacancy = Vacancy::findOrFail($item['vacancy_id']);

                    if($user) {
                        $user->vacancy_type = $user->getVacancyType ? $user->getVacancyType->getName($lang) : null;
                        $user->business = $user->getBusiness ? $user->getBusiness->getName($lang) : null;
                        $user->region = $user->getRegion ? $user->getRegion->getName($lang) : null;
                        $user->district = $user->getDistrict ? $user->getDistrict->getName($lang) : null;
                        $user->status_text = $user->getStatusPlain();
                        $user->status = $user->active;
                        $user->currency = $user->getCurrency ? $user->getCurrency->code : '';
                        $user->response_type = $item['type'];
                        $user->response_read = $item['read'];
                        $user->vacancy_types = $user->vacancy_types ? VacancyType::whereIn('id', $user->vacancy_types)->pluck('name_ru')->toArray() : null;
                        $user->schedules = $user->schedules ? Schedule::whereIn('id', $user->schedules)->pluck('name_ru')->toArray() : null;
                        $user->vacancy_name = $vacancy->name;
                        $user->user_vacancy_id = $vacancy->id;
                        $user->vacancy_date = $item['created_at'];

                        $users[] = $user;
                    }
                }
//            }

            return response()->json($users);
        }
        else{
            return 'FALSE';
        }

    }

    public function changeStatus(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where("password", $token)->firstOrFail();
        $status = $request->status;

        if($user) {
            $user->active = $status;
            $user->save();
            return response()->json([
                'message' => 'OK'
            ], 200);
        } else {
            return response()->json([
                'id' => null,
                'token' => null,
                'message' => 'User does not exist',
                'status' => 400,
            ]);
        }
    }

    public function changeSchedules(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where("password", $token)->firstOrFail();
        $schedules = $request->schedules;

        if($user) {
            $user->schedules = $schedules;
            $user->save();
            return response()->json([
                'message' => 'OK'
            ], 200);
        } else {
            return response()->json([
                'id' => null,
                'token' => null,
                'message' => 'User does not exist',
                'status' => 400,
            ]);
        }
    }

    public function changeVacancyTypes(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where("password", $token)->firstOrFail();
        $vacancy_types = $request->vacancy_types;

        if($user) {
            $user->vacancy_types = $vacancy_types;
            $user->save();
            return response()->json([
                'message' => 'OK'
            ], 200);
        } else {
            return response()->json([
                'id' => null,
                'token' => null,
                'message' => 'User does not exist',
                'status' => 400,
            ]);
        }
    }

    public function getSchedules(Request $request, $id)
    {
        $result = [];

        $user = User::findOrFail($id);
        if($user) {
            $result = $user->schedules ?? [];
        }

        return $result;
    }

    public function getVacancyTypes(Request $request, $id)
    {
        $result = [];

        $user = User::findOrFail($id);
        if($user) {
            $result = $user->vacancy_types ?? [];
        }

        return $result;
    }



    public function getUnreadResponses(Request $request)
    {
        $lang = $request->lang;
        $token = $request->header('Authorization');
        $user = User::where("password", $token)->firstOrFail();
        $result = 0;

        if($user){

            if($user->type == 'COMPANY'){
//                $invited = UserCompany::whereNotNull('vacancy_id')->whereIn('type', ['INVITED'])
//                    ->where('company_id', $user->id)->where('read', false)->count();

                $companyVacancies = Vacancy::where('company_id', $user->id)->pluck('id')->toArray();
                $submitted = UserVacancy::whereIn('type', ['SUBMITTED'])
                    ->whereIn('vacancy_id', $companyVacancies)->where('read', false)->count();

//                $result = $invited + $submitted;
                $result = $submitted;
            } else {
                $invited = UserCompany::whereNotNull('vacancy_id')->whereIn('type', ['INVITED'])
                    ->where('user_id', $user->id)->where('read', false)->count();

//                $submitted = UserVacancy::whereIn('type', ['SUBMITTED'])
//                    ->where('user_id', $user->id)->where('read', false)->count();

//                $result = $invited + $submitted;
                $result = $invited;
            }

        }

        return $result;
    }

    public function userVacancyRead(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user_vacancy = UserVacancy::where('vacancy_id', $request->user_vacancy_id)->where('user_id', $request->user_id)->first();

        if($user) {
            if($user_vacancy) {
                $user_vacancy->read = true;
                $user_vacancy->save();
                return response()->json([
                    'message' => 'OK'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'User vacancy does not exist',
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
