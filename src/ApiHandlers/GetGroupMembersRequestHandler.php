<?php 
namespace App\ApiHandlers;

use App\Models\Group;
use App\RequestHandler;
use App\ValidateResult;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class GetGroupMembersRequestHandler extends RequestHandler{

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
        else{
            $result->validated['group'] = $input->group;
        }
        return $result;
    }
    public function run(object $input = null){
        $group = Group::where('title', $input->group)->first();
        return $group->members;
    }
}