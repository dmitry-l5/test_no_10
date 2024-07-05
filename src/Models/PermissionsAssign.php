<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionsAssign extends Model{

    protected $fillable = [
        'group_id',
        'permission_id'
    ];
}