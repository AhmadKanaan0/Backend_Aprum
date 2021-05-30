<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APUserStatus extends Model
{
    use HasFactory;
    protected $table = "apUser_status";
    protected $primaryKey = "UID";
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
