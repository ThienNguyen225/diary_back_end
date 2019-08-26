<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassword;
use App\Http\Requests\StoreUser;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userServices)
    {
        $this->userService = $userServices;
    }

    public function register(StoreUser $request)
    {
        try {
            $newRequest = $this->bcryptPassword($request->all());
            $data = $this->userService->create($newRequest);
            return response()->json([
                'data' => $data['result'],
                'status' => $data['status']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!($token = JWTAuth::attempt($credentials))) {
            return response()->json([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'token' => $token,
        ], Response::HTTP_OK);
    }

    public function user(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return response($user, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_BAD_REQUEST);
    }

    public function updateUser(Request $request)
    {
        try {
            $user = Auth::user();
            $user->update($request->all());
            return response()->json([
                'data' => $user,
                'status' => 'susses'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function logout(Request $request)
    {
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json('You have successfully logged out.', Response::HTTP_OK);
        } catch (JWTException $e) {
            return response()->json('Failed to logout, please try again.', Response::HTTP_BAD_REQUEST);
        }
    }

    public function refresh()
    {
        return response(JWTAuth::getToken(), Response::HTTP_OK);
    }

    public function changePassword(ChangePassword $request)
    {
        //request:{ current-password, new-password, new-password_confirmation }
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return response()->json(array(
                "error" => "Your current password does not matches with the password you provided. Please try again."
            ));
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return response()->json(array(
                "error", "New Password cannot be same as your current password. Please choose a different password."
            ));
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return response()->json(array(
            "success", "Password changed successfully !"
        ));
    }

    public function bcryptPassword($request)
    {
        foreach ($request as $key => $value) {
            if ($key === "password") {
                $request["$key"] = Hash::make("$value");
                break;
            }
        }
        return $request;
    }

}
