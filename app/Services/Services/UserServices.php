<?php


namespace App\Services\Services;


use App\Repositories\Contracts\UserInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserServices extends Service implements UserServiceInterface
{

    public function __construct(UserInterface $userRepository)
    {
        $this->setUserRepository($userRepository);
    }

    public function changePassword($request)
    {
        //request:{ current_password, new_password, new_password_confirmation }
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            return response()->json(array(
                "error" => "Your current password does not matches with the password you provided. Please try again."
            ));
        }

        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            //Current password and new password are same
            return response()->json(array(
                "error", "New Password cannot be same as your current password. Please choose a different password."
            ));
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();
        return response()->json(array(
            "success", "Password changed successfully !"
        ));
    }
}
