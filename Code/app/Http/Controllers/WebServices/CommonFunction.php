<?php

namespace App\Http\Controllers\WebServices;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UsedConstants\ConstantsAndVariables;
use App\Models\TPassword;
use App\Models\APUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CommonFunction extends Controller
{
    public function savePhoto($photo,$file){
        $file_extention = $photo->getClientOriginalExtension();
        $file_name = time().'.'.$file_extention;
        $path = $file;
        $photo->move(ConstantsAndVariables::LinkPhoto.$path,$file_name);
        $path = $path.'\\'.$file_name;
        return $path;
    }

    public function getUserLogin($email)
    {
        $sub = APUser::where("EMAIL","=",$email)->first();
        return $sub;
    }

    public function checkPassword($password, $user)
    {
        $pass = TPassword::where("SUB_ID","=",$user->UID)->first();
        return Hash::check($password, $pass->CPWD);
    }
}
