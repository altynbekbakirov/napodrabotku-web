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

class UserCvExperienceController extends Controller
{
    public function store(Request $request)
    {
        $token = $request->header('Authorization');

        $user = User::where("password", $token)->firstOrFail();

        if ($user) {
            $this->validate($request, [
                'job_title' => ['required'],
            ]);

            $user_experience = UserExperience::create([
                'job_title' => $request->job_title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'organization_name' => $request->organization_name,
                'description' => $request->description,
                'user_cv_id' => $request->user_cv_id,
            ]);
            $user_experience->save();

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

            $user_experience = UserExperience::findOrFail($id);

            $user_experience->update([
                'job_title' => $request->job_title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'organization_name' => $request->organization_name,
                'description' => $request->description,
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
            UserExperience::where('id', $id)->delete();
            return "OK";
        } else {
            return "token is not valid";
        }
    }
}
