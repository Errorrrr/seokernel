<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doubles extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'queryList',
        'nameExcelFile',
        'user_id'
    ];
}
