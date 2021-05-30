<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APCategory extends Model
{
    use HasFactory;
    protected $table = "ar_category";
    protected $primaryKey = 'UID';
    public $timestamps = false;
}
