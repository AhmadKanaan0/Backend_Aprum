<?php

namespace App\Http\Controllers\UsedConstants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorCode extends Controller
{
    const WorkValid = 200;
    const LoginSuccessfully = 0;
    const PasswordExpired = -1;
    const LoginMisMatch = -2;
    const UnknownEmail = -3;
    const UserBlocked = -4;
    const PasswordsNotSame = -5;
    const OldPasswordWrong = -6;
    const EmailInvalid = -7;
    const LinkExpired = -8;
    const LinkNotExist = -9;
    const InvalidToken = -10;
    const UnAuthenticate = 402;
    const UnAuthorize = 401;
    const CodeValid = 200;
    const Success = 200;
    const SomthingWrong = 403;
    const Pay = 405;
    const DateNotCorrect = -11;
    const EmailExist = -12;
    const ContributorEmpty = -13;
    const DepartmentEmpty = -14;
    const OrganizationExist = -15;
}
