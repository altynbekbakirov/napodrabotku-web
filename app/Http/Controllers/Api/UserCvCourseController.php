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

class UserCvCourseController extends Controller
{
    public function store(Request $request)
    {
        $token = $request->header('Authorization');

        $user = User::where("password", $token)->firstOrFail();

        if ($user) {
            $this->validate($request, [
                'name' => ['required'],
            ]);

            $user_course = UserCourse::create([
                'name' => $request->name,
                'organization_name' => $request->organization_name,
                'duration' => $request->duration,
                'end_year' => $request->end_year,
                'user_cv_id' => $request->user_cv_id,
            ]);
            $user_course->save();

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
            $this->validate($request, [
                'name' => ['required'],
            ]);

            $user_course = UserCourse::findOrFail($id);

            $user_course->update([
                'name' => $request->name,
                'organization_name' => $request->organization_name,
                'duration' => $request->duration,
                'end_year' => $request->end_year,
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
            UserCourse::where('id', $id)->delete();
            return "OK";
        } else {
            return "token is not valid";
        }
    }
}
