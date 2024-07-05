<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAssign extends Model{
    protected $fillable = [
        'user_id',
        'group_id'
    ];

}