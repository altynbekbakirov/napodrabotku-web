<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\EducationType;
use App\Models\UserCourse;
use App\Models\UserCV;
use App\Models\UserEducation;
use App\Models\UserExperience;
use function MongoDB\BSON\toJSON;

class UserCvController extends Controller
{
    public function index(Request $request)
    {

        $token = $request->header('Authorization');

        $user = User::where("password", $token)->firstOrFail();

        if ($user) {
            $result = [];
            $user_cv = UserCV::where('user_id', $user->id)->firstOrFail();
//            dd("user_cv");
            if ($user_cv) {
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

                array_push($result, [
                    'id' => $user_cv->id,
                    'experience_year' => $user_cv->experience_year,
                    'job_title' => $user_cv->job_title,
                    'user_id' => $user_cv->user_id,
                    'attachment' => $user_cv->attachment,
                    'educations' => $user_educations,
                    'courses' => $user_courses,
                    'experiences' => $user_experiences,
                ]);
                return $result;
            } else {
                return null;
            }
        } else {
            return "token is not valid";
        }

    }

    public function store(Request $request)
    {
        $token = $request->header('Authorization');

        $user = User::where("password", $token)->firstOrFail();

        $user_cv = new UserCV();

        if ($user) {
            if(!$request->is_product_lab_user) {
                $this->validate($request, [
                    'job_title' => ['required'],
                    'experience_year' => ['required'],
                ]);
            }

            if ($request->user_cv_id) {
                $user_cv = UserCV::findOrFail($request->user_cv_id);
                $user_cv->update([
                    'job_title' => $request->job_title,
                    'experience_year' => $request->experience_year,
                ]);
            } else {
                $user_cv = UserCV::create([
                    'job_title' => $request->job_title ? $request->job_title : null,
                    'user_id' => $request->user_id,
                    'experience_year' => $request->experience_year ? $request->experience_year : null,
                ]);

            }
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = Carbon::now()->format('YmdHms') . '.' . $file->getClientOriginalExtension();
                $path = 'storage/attachments/' . $filename;
                $file->move(public_path() . '/storage/attachments/', $filename);
                $user_cv->attachment = $path;
            }
            $user_cv->save();

            $experiences = $request->user_experiences;
            $educations = $request->user_educations;
            $courses = $request->user_courses;

            if ($experiences) {
                foreach (json_decode($experiences) as $experience) {
                    if ($experience->id) {

                        $user_experience = UserExperience::findOrFail($experience->id);
                        $user_experience->update([
                            'job_title' => $experience->job_title,
                            'start_date' => $experience->start_date,
                            'end_date' => $experience->end_date,
                            'organization_name' => $experience->organization_name,
                            'description' => $experience->description,
                        ]);
                        $user_experience->save();
                    } else {
                        $user_experience = UserExperience::create([
                            'job_title' => $experience->job_title,
                            'start_date' => $experience->start_date,
                            'end_date' => $experience->end_date,
                            'organization_name' => $experience->organization_name,
                            'description' => $experience->description,
                            'user_cv_id' => $user_cv->id,
                        ]);
                        $user_experience->save();
                    }
                }
            }

            if ($educations) {
                foreach (json_decode($educations) as $education) {
                    if ($education->id) {
                        $user_education = UserEducation::findOrFail($education->id);
                        $user_education->update([
                            'title' => $education->title,
                            'faculty' => $education->faculty,
                            'speciality' => $education->speciality,
                            'type_id' => 3,
                            'end_year' => (int)$education->end_year,
                        ]);
                        $user_education->save();
                    } else {
                        $user_education = UserEducation::create([
                            'title' => $education->title,
                            'faculty' => $education->faculty,
                            'speciality' => $education->speciality,
                            'type_id' => 2,
                            'end_year' => (int)$education->end_year,
                            'user_cv_id' => $user_cv->id,
                        ]);
                        $user_education->save();
                    }
                }
            }

            if ($courses) {
                foreach (json_decode($courses) as $course) {
                    if ($course->id) {
                        $user_course = UserCourse::findOrFail($course->id);
                        $user_course->update([
                            'name' => $course->name,
                            'organization_name' => $course->organization_name,
                            'duration' => $course->duration,
                            'end_year' => $course->end_year,
                            'user_cv_id' => $user_cv->id,
                        ]);
                        $user_course->save();
                    } else {
                        $user_course = UserCourse::create([
                            'name' => $course->name,
                            'organization_name' => $course->organization_name,
                            'duration' => $course->duration,
                            'end_year' => $course->end_year,
                            'user_cv_id' => $user_cv->id,
                        ]);
                        $user_course->save();
                    }
                }
            }

//            dd($request->experiences);


            return "OK";
        } else {
            return "token is not valid";
        }
    }
}
