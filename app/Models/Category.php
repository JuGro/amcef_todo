<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Relationship to User
    public function todo()
    {
        return $this->hasMany(Todo::class, 'category_id');
    }
}
