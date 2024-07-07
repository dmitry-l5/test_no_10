<?php
use App\ValidateResult;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require(__DIR__.'/../vendor/autoload.php');
use App\Application;
$app = App\Application::instance();
$r_handler = Application::getHandler($_SERVER['REQUEST_URI']);
$input = $r_handler->validate(json_decode(file_get_contents("php://input"), false) ? json_decode(file_get_contents("php://input"), false) : (object)[] );
if($input && !empty($input->status) && $input->status == ValidateResult::SUCCESS)
{
    $data = $r_handler->run((object)$input->validated);
}
else{
    $data = (object)['errors'=> !empty($input->errors)? $input->errors : 'try to /api/method_name or /demo.php'];
}
$app->responseJson($data);