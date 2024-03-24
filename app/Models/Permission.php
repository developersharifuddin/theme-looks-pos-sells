<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $fillable = [
        'name', 'guard_name', 'group_name'
    ];




    // Check if the user has the given permission
    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
    }
}
