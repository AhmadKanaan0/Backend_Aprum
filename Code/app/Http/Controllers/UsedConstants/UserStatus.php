<?php

namespace App\Http\Controllers\UsedConstants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserStatus extends Controller
{
    const ACTIVE = "ACTIVE";
    const BLOCKED = "BLOCKED";
    const INACTIVE = "INACTIVE";
    const PENDING = "PENDING";
}
