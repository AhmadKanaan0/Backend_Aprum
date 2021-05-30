<?php

namespace App\Models;

use App\Http\Controllers\UsedConstants\ConstantsAndVariables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class TPassword extends Model
{
    use HasFactory;
    protected $table = "tpassword";
    protected $primaryKey = 'UID';
    public $timestamps = false;

    public function createPassword($subID, $password)
    {

        $this->SUB_ID = $subID;
        $this->CPWD = Hash::make($password);
        $this->SETTING_DATE = date(ConstantsAndVariables::DateTimeFormat);
        $this->save();
    }

}
