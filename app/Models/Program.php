<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_program',
        'faculty_id',
    ];

    public function faculty()
    {
        return $this->belongsTo("App\Models\Faculty", "faculty_id");
    }
}
