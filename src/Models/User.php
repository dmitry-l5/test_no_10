<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Permission;

class User extends Model{

    protected $fillable = [
        'uuid',
        'name'
    ];

    public function groups(): HasManyThrough
    {
        return $this->HasManyThrough(Group::class, GroupAssign::class, 'user_id', 'id', 'id', 'group_id');
    }
    
    public function getPermissions(){
        $groups = $this->groups;
        $permissions = collect();
        $permissions_invert = collect();
        $groups->map(function($item)use(&$permissions, &$permissions_invert){
            if($item->invert)
                $permissions_invert = $permissions_invert->union($item->permissions);
            else
                $permissions = $permissions->union($item->permissions);
            return $item;
        });
        $permissions_all = array_map(function($item)use(&$permissions, &$permissions_invert){
            $result = [
                'title'=>$item['title'],
                'assigned'=>(count($permissions->where('title',$item['title'])) && !count($permissions_invert->where('title',$item['title'])))?'true':'false'
            ];
            return $result;
        },
        Permission::get()->toArray()
        );
        return (object)$permissions_all;
    }
}