<?php 
namespace App\ApiHandlers;

use App\Models\Group;
use App\Models\GroupAssign;
use App\RequestHandler;
use App\ValidateResult;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class AssignGroupRequestHandler extends RequestHandler{

    public function validate(object $input):ValidateResult{
        $result = new ValidateResult();
        $result->status = ValidateResult::SUCCESS;
        if(
            empty($input->group) || 
            !(Group::where('title', $input->group)->first())
        )
        {
            $result->status = ValidateResult::FAIL;
            $result->errors[] = "Такой группы не существует";
        }
        else
        {
            $result->validated['group'] = $input->group;
        }
        if(
            empty($input->user_id) ||
            !(User::find(intval($input->user_id)))
        ){
            $result->status = ValidateResult::FAIL;
            $result->errors[] = "Пользователь не найден";
        }
        else
        {
            $result->validated['user_id'] = intval($input->user_id);
        }
        return $result;
    }
    public function run(object $input = null){
        $group = Group::where('title', ($input->group ?? ''))->first();
        $user = User::find($input->user_id ?? -1);
        if(!$group || !$user ){
            return (object)['status'=>'error', 'message'=>"Данные не верны"];
        }
        if(GroupAssign::where(['user_id'=>$user->id, 'group_id'=>$group->id])->first())
        {
            return (object)['status'=>'success', 'message'=>"Пользователь уже находится в группе '{$group->title}'"];
        }
        GroupAssign::create([
            'user_id' => $user->id,
            'group_id'=>$group->id
        ]);
        return (object)['status'=>'success', 'message'=>"Пользователь '{$user->name}' добавлен в группу '{$group->title}'"];
    }
}