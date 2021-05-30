<?php

namespace App\Http\Controllers\WebServices;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UsedConstants\ConstantsAndVariables;
use App\Http\Controllers\UsedConstants\ErrorCode;
use App\Http\Controllers\UsedConstants\UserStatus;
use App\Models\TAttempts;
use App\Models\TPassword;
use App\Models\APUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoginWebService extends Controller
{
    private $commonFunction;

    public function __construct(){
        $this->commonFunction = new CommonFunction();
    }

    private function checkAttempts($contributor)
    {  $attempt = TAttempts::where("SUB_ID","=",$contributor->UID)->first();
        if ($attempt->ATTEMPT == -2) return true;
    else {
        return $attempt->ATTEMPT > 0;
    }
    }

    private function checkExisting($contributor)
    {
        return $contributor !== null;
    }

    private function checkTime($contributor)
    {
        $passDate = TPassword::where("SUB_ID","=",$contributor->UID)->first();
        $start_date = strtotime($passDate->SETTING_DATE);
        $end_date = strtotime(Carbon::now()->format(ConstantsAndVariables::DateTimeFormat));
        $expiredTime = ($end_date - $start_date) / 60 / 60 / 24;
        return $expiredTime < ConstantsAndVariables::ExpiredTime;
    }

    private function updateAttempts($contributor, $action)
    {

        $up = TAttempts::where("SUB_ID", "=", $contributor->UID)->first();
        if ($action === "reset") {
            $up->ATTEMPT = ConstantsAndVariables::Attempts;
            $up->save();
        } else if ($action === "update") {
            $up->ATTEMPT -= 1;
            $up->save();
        }

    }

    private function updateStatus($contributor)
    {
        $up = APUser::find($contributor->UID);
        $up->CSTATUS = UserStatus::BLOCKED;
        $up->save();
    }


    protected function SubscriberRegister_API(Request $request){
        $sub = APUser::where("EMAIL","=",$request->EMAIL)->first();
        if($sub){
            return ConstantsAndVariables::EmailAreadyExist;
        }

        if($request->PASSWORD === $request->CONFIRMPASSWORD) {

            $subscriber = new APUser();
            $subscriber->addUser($request);

            $contpass = new TPassword();
            $contpass->createPassword($subscriber->UID,$request->PASSWORD);

            $attempts = new TAttempts();
            $attempts->createAttempt($subscriber->UID);

            return ConstantsAndVariables::Success;
        }else return ConstantsAndVariables::PasswordNotSame;


    }

    protected function loginValidation_API(Request $request)
    {
        $email = $request->EMAIL;
        $password = $request->PASSWORD;


            $user = $this->commonFunction->getUserLogin($email); //$this->getContributor($email, $orId);

            if ($this->checkExisting($user)) {
                $attempt = TAttempts::where("SUB_ID","=",$user->UID)->first();
                    if ($this->checkTime($user)) {
                        if ($this->checkAttempts($user)) {
                            if ($this->commonFunction->checkPassword($password, $user)) {
                                $this->updateAttempts($user, "reset");
                                $data = array();
                                array_push($data,ErrorCode::Success);
                                array_push($data,$user->ROLE);
                                return $data;
                            } else {
                                if ($attempt->ATTEMPT == -2) {
                                    return ErrorCode::LoginMisMatch;
                                } else {
                                    $this->updateAttempts($user, "update");
                                    return ErrorCode::LoginMisMatch;
                                }

                            }
                        } else {

                            if ($attempt->ATTEMPT === 0) {
                                $this->updateStatus($user);
                                $this->updateAttempts($user, "update");
                            }

                            return ErrorCode::UserBlocked;
                        }

                    } else {
                        return ErrorCode::PasswordExpired;
                    }

            } else {
                return ErrorCode::UnknownEmail;
            }



    }

    protected function SignUp_API(Request $request){
        $sub = APUser::where ("EMAIL","=",$request->EMAIL)->first();
        if($sub){
            return ConstantsAndVariables::EmailAreadyExist;
        }

        if($request->PASSWORD === $request->CONFIRMPASSWORD) {

            $user = new APUser();
            $user->addUserSignup($request);

            $contpass = new TPassword();
            $contpass->createPassword($user->UID,$request->PASSWORD);

            $attempts = new TAttempts();
            $attempts->createAttempt($user->UID);

            return ConstantsAndVariables::Success;
        }else return ConstantsAndVariables::PasswordNotSame;


    }



}
