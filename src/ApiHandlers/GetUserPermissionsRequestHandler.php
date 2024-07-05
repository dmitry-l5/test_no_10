<?php 
namespace App\ApiHandlers;

use App\Models\Group;
use App\RequestHandler;
use App\ValidateResult;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class GetUserPermissionsRequestHandler extends RequestHandler{

    public function validate(object $input):ValidateResult{
        $result = new ValidateResult();
        $result->status = ValidateResult::SUCCESS;
        if(
            empty($input->user_id) || 
            !(User::find(intval($input->user_id)))
        )
        {
            $result->status = ValidateResult::FAIL;
            $result->errors[] = "Пользователь не найден";
        }
        else{
            $result->validated['user_id'] = $input->user_id;
        }
        return $result;
    }
    public function run(object $input = null){
        $user = User::find(($input->user_id ?? -1));
        if($user){
            return $user->getPermissions();
        }
        return (object)['status'=>'error', 'message'=>"run : Пользователь не найден"];
    }
}