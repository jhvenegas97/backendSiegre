<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_level_id',
        'user_id',
        'title_academic',
        'init_date_academic',
        'end_date_academic',
        'fileName_academic',
        'path_academic',
    ];
}
