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

class UserCvEducationController extends Controller
{
    public function store(Request $request)
    {
        $token = $request->header('Authorization');

        $user = User::where("password", $token)->firstOrFail();

        if ($user) {
            $this->validate($request, [
                'title' => ['required'],
            ]);

            $user_education = UserEducation::create([
                'title' => $request->title,
                'faculty' => $request->faculty,
                'speciality' => $request->speciality,
                'end_year' => $request->end_year,
                'type_id' => 1,
                'user_cv_id' => $request->user_cv_id,
            ]);
            $user_education->save();

            return "OK";
        } else {
            return "token is not valid";
        }
    }

    public function update(Request $request, $id)
    {
        $token = $request->header('Authorization');

        $user = User::where("password", $token)->firstOrFail();

        if ($user) {
//            $this->validate($request, [
//                'job_title' => ['required'],
//                'start_date' => ['required'],
//                'end_date' => ['required'],
//                'organization_name' => ['required']
//            ]);

            $user_education = UserEducation::findOrFail($id);

            $user_education->update([
                'title' => $request->title,
                'faculty' => $request->faculty,
                'speciality' => $request->speciality,
                'end_year' => $request->end_year,
                'type_id' => 1,
            ]);

            return "OK";
        } else {
            return "token is not valid";
        }
    }

    public function delete(Request $request, $id)
    {
        $token = $request->header('Authorization');

        $user = User::where("password", $token)->firstOrFail();

        if ($user) {
            UserEducation::where('id', $id)->delete();
            return "OK";
        } else {
            return "token is not valid";
        }
    }
}
