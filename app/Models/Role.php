<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Relationship to User
    public function users()
    {
        return $this->HasMany(User::class, 'role_id');
    }
}
