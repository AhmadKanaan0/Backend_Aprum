<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APAuthor extends Model
{
    use HasFactory;
    protected $table = "ar_author";
    protected $primaryKey = 'UID';
    public $timestamps = false;
}
