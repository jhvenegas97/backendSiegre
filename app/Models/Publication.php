<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id");
    }

    public function category()
    {
        return $this->belongsTo("App\Models\CategoryPublication", "category_publication_id");
    }
}
