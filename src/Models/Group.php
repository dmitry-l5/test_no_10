<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\GroupAssign;
use App\Models\Permission;
use App\Models\PermissionsAssign;

class Group extends Model{
    protected $fillable = [
        'uuid',
        'title',
        'invert'
    ];
    public function members(): HasManyThrough
    {
        return $this->HasManyThrough(User::class, GroupAssign::class, 'group_id', 'id', 'id', 'user_id');
    }
    public function permissions(): HasManyThrough
    {
        return $this->HasManyThrough(Permission::class, PermissionsAssign::class, 'group_id', 'id', 'id', 'permission_id');
    }

}