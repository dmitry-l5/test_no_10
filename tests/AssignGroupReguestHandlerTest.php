<?php
use PHPUnit\Framework\TestCase;
use App\ApiHandlers\AssignGroupRequestHandler;
use App\ValidateResult;

class AssignGroupReguestHandlerTest extends TestCase{

    public function testValidate(){
        $handler = new AssignGroupRequestHandler();

        $result = $handler->validate((object)['group'=>'dev', 'user_id'=>1]);
        $velidate = new ValidateResult();
        $velidate->status = ValidateResult::SUCCESS;
        $velidate->validated['group'] = 'dev';
        $velidate->validated['user_id'] = 1;
        $this->assertEquals($velidate, $result);

        $result = $handler->validate((object)['group'=>'non_exist', 'user_id'=>-10101]);
        $velidate = new ValidateResult();
        $velidate->status = ValidateResult::FAIL;
        $velidate->errors[] = "Такой группы не существует";
        $velidate->errors[] = "Пользователь не найден";
        $this->assertEquals($velidate, $result);

        $result = $handler->validate((object)[]);
        $velidate = new ValidateResult();
        $velidate->status = ValidateResult::FAIL;
        $velidate->errors[] = "Такой группы не существует";
        $velidate->errors[] = "Пользователь не найден";
        $this->assertEquals($velidate, $result);
    }
    
    public function testRun(){
        $handler = new AssignGroupRequestHandler();
        $result = $handler->run((object)[]);
        $this->assertEquals(
            (object)['status'=>'error', 'message'=>"Данные не верны"],
            $result
        );

    }
}