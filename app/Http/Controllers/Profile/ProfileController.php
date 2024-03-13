<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function Index(){
        $title = 'profile';
        
        return view('home.profile.index', compact(
            'title'
        ));
    }

    public function changePassword(){
        $title = 'Change Password';
        return view('home.profile.change-password', compact(
            'title'
        ));
    }

    public function updatePassword(Request $request){
        //validate
        
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:6',
            'confirmation_password' => 'required|min:6'
        ]);

        $currentPasswordStatus = Hash::check(
            $request->current_password, auth()->user()->password  
        );

        if($currentPasswordStatus){
            if ($request->password == $request->confirmation_password) {
                //get user login by auth
                $user = auth()->user();

                 //update password
                $user->password = Hash::make($request->password);
                $user->save();
                
                return redirect()->back()->with('success', 'password has been updated');
                
            } else {
                return redirect()->back()->with('error', 'password does not match');
            }
        } else {
            return redirect()->back()->with('error', 'Current Password is wrong');
        }
    }
}