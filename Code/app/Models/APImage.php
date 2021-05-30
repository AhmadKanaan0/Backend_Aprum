<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APImage extends Model
{
    use HasFactory;
    protected $table = "ar_image";
    protected $primaryKey = 'UID';
    public $timestamps = false;
}
