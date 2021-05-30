<?php

namespace App\Models;

use App\Http\Controllers\UsedConstants\ConstantsAndVariables;
use App\Http\Controllers\UsedConstants\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class APUser extends Model
{
    use HasFactory;
    protected $table = "apUser";
    protected $primaryKey = 'UID';
    public $timestamps = false;

    public function addUser(Request $request)
    {
        $this->FIRSTNAME = $request->FIRSTNAME;
        $this->LASTNAME = $request->LASTNAME;
        $this->EMAIL = $request->EMAIL;
        $this->GENDER = $request->GENDER;
        $this->STATUS = UserStatus::ACTIVE;
        $this->save();
    }

    public function addUserSignup(Request $request)
    {
        $this->EMAIL = $request->EMAIL;
        $this->STATUS = UserStatus::ACTIVE;
        $this->save();
    }

}
