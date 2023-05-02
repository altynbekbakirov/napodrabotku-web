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
    /**
     * @OA\Post(
     *     path="/userexist",
     *     operationId="check username",
     *     tags={"UserAuth"},
     *     summary="Create yet another user record",
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"username"},
     *       @OA\Property(property="username", type="string", example="user"),
     *    )
     *     ),
     *    @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * ),
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
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
            return response()->json(false);
        }
        return response()->json(true);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="userCreate",
     *     tags={"UserAuth"},
     *     summary="Create yet another user record",
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"username","password"},
     *       @OA\Property(property="username", type="string", format="string", example="user"),
     *       @OA\Property(property="password", type="string", format="password", example="user123"),
     *    )
     *     ),
     *    @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * ),
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response
     */
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
                    'token' => $user->value('password')
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
            if (Hash::check($request->password, $user->value('password'))) {
                return response([
                    'id' => $user->value('id'),
                    'avatar' => $user->value('avatar'),
                    'user_type' => $user->value('type'),
                    'token' => $user->value('password'),
                    'email' => $user->value('email'),
                ]);

            }
            return response([
                'message' => 'password incorrect',
                'status' => 999
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/logged",
     *     operationId="logged",
     *     tags={"UserAuth"},
     *     summary="Create yet another user record",
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"id"},
     *       @OA\Property(property="id", type="integer", example=18),
     *    )
     *     ),
     *    @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * ),
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
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
