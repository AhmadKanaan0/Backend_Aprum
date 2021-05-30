<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APBlogHeadline extends Model
{
    use HasFactory;
    protected $table = "ap_blogheadline";
    protected $primaryKey = 'UID';
    public $timestamps = false;
}
