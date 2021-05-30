<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APProjectMeta extends Model
{
    use HasFactory;
    protected $table = "ap_project_meta";
    protected $primaryKey = 'UID';
    public $timestamps = false;
}
