<?php

namespace App\Http\Controllers\UsedConstants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConstantsAndVariables extends Controller
{
    const LinkPhoto = "C:\wamp64\www\afaqcm\\";
    const PhotoArticleSrc = "images\article";
    const DateTimeFormat = 'Y-m-d H:i:s';
    const ExpiredTime = 30;//days
    const Success = 200;
    const EmailAreadyExist = -1;
    const PasswordNotSame = -2;
    const Attempts = 5;
}
