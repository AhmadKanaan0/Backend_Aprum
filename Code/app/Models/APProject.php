<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APProject extends Model
{
    use HasFactory;
    protected $table = "ap_project";
    protected $primaryKey = 'UID';
    public $timestamps = false;
}
