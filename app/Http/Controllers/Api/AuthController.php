<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Notifications\SignupActivate;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function checkusername(Request $request)
    {
        if (User::where('email', $request->email)->count() == 0) {
            return response()->json(false);
        }
        return response()->json(true);
    }

    public function checkphone(Request $request)
    {
        if (User::where('phone_number', $request->phone_number)->count() == 0) {
            return response()->json(1);
        }
        return response()->json(0);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email);
        if (is_null($user->value('email'))) {
            return response([
                'message' => 'email incorrect',
                'status' => 888
            ]);
        } else {
            if (Hash::check($request->password, $user->value('password'))) {
                return response([
                    'id' => $user->value('id'),
                    'avatar' => $user->value('avatar'),
                    'user_type' => $user->value('type'),
                    'lat' => $user->value('lat'),
                    'long' => $user->value('long'),
                    'token' => $user->value('password'),
                    'active' => $user->value('active'),
                    'schedules' => $user->value('schedules'),
                    'vacancy_types' => $user->value('vacancy_types'),
                ]);

            }
            return response([
                'message' => 'password incorrect',
                'status' => 999
            ]);
        }
    }

    public function login_phone(Request $request)
    {
        $user = User::where('phone_number', $request->phone_number);
        if (is_null($user->value('phone_number'))) {
            return response([
                'message' => 'phone incorrect',
                'status' => 888
            ]);
        } else {
            return response([
                'id' => $user->value('id'),
                'avatar' => $user->value('avatar'),
                'user_type' => $user->value('type'),
                'token' => $user->value('password'),
                'phone_number' => $user->value('phone_number'),
                'email' => $user->value('email'),
                'lat' => $user->value('lat'),
                'long' => $user->value('long'),
                'active' => $user->value('active'),
                'schedules' => $user->value('schedules'),
                'vacancy_types' => $user->value('vacancy_types'),
            ]);
        }
    }

    public function logged(Request $request)
    {
        $user = User::find($request->id);
        if ($user!=null) {
            $user->update([
                'logged'=>false,
            ]);
            return response()->json('successfully');
        }
        return response()->json('user id does not exist');

    }

}
