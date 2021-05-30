<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APProjectAuthor extends Model
{
    use HasFactory;
    protected $table = "ap_project_author";
    protected $primaryKey = 'UID';
    public $timestamps = false;
}
