<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserResetCode;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendMailToEmail(Request $request)
    {
        $email = $request->email;

        $six_digit_random_number = mt_rand(100000, 999999);
        $user = User::where('email', $email)->firstOrFail();
        if ($user) {

            $subject1 = 'Сброс пароля';
            $body_text = 'Код для сброса пароля: ';
            if($request->language =='ky') {
                $subject1 = 'Сырсөз жаңыртуу';
                $body_text = 'Сырсөзүңүздү жаңыртуу үчүн код: ';
            }

//            Mail::to($email->email)->send(new ForgotPasswordMail($subject1, $body_text));

            Mail::raw("{$body_text} {$six_digit_random_number}", function ($m) use ($user, $subject1) {
                $m->from('info@ishtapp.kg', 'ishtapp');
                $m->to($user->email, $user->name)->subject($subject1);
            });

            $code = UserResetCode::create([
                'code' => $six_digit_random_number,
                'user_id' => $user->id,
            ]);
            $code->save();
            return "OK";
        }
        return response()->json('user id does not exist');

    }

    public function validateCode(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->firstOrFail();
        if($user) {
            $code = $request->code;
            $user_code = UserResetCode::where('user_id', $user->id)
                ->where('code', $code)
                ->orderBy('created_at', 'desc')
                ->first();
            if ($user_code) {
                return response()->json([
                    'id' => $user->id,
                    'email' => $user->email,
                    'validated' => true,
                    'message' => 'Successfully validated!',
                    'avatar' => $user->avatar,
                    'status' => 200
                ], 200);
            }
            else
                return response()->json('user code does not exist');
        }
        return response()->json('user id does not exist');

    }
    public function resetPassword(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->firstOrFail();
        if($user) {
            $new_password = $request->new_password;
            if ($new_password) {
                $new_password = Hash::make($new_password);
            }
            $user ->password = $new_password;
            $user->save();
            return response()->json([
                'token' => $user->password,
                'message' => 'Password successfully reset!',
                'status' => 200
            ], 200);
        }
        return response()->json('user id does not exist');

    }

}
