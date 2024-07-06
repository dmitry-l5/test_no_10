<?php 
namespace App\ApiHandlers;

use App\RequestHandler;
use Illuminate\Support\Facades\Response;

class DefaultRequestHandler extends RequestHandler{

    public function validate(object $input):?object{
        return $input;
    }
    public function run(object $input = null){
        return (object)[
            'status' => 'success',
            'content'=>[
            
            ]
        ];
    }
}