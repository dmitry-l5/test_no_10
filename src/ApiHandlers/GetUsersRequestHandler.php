<?php 
namespace App\ApiHandlers;

use App\RequestHandler;
use App\ValidateResult;
use App\Models\User;

class GetUsersRequestHandler extends RequestHandler{

    public function validate(object $input):ValidateResult{
        $result = new ValidateResult();
        $result->status = ValidateResult::SUCCESS;
        return $result;
    }
    public function run(object $input = null){
        $users = User::select(['uuid', 'name'])->get();
        return $users;
    }
}