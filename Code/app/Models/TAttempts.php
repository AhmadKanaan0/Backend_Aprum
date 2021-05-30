<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TAttempts extends Model
{
    use HasFactory;
    protected $table = "tattempts";
    protected $primaryKey = 'UID';
    public $timestamps = false;

    public function createAttempt($subId)
    {
        $this->SUB_ID = $subId;
        $this->save();
    }
}
