<?php
use App\ApiHandlers\GetUsersRequestHandler;
use App\Application;
use App\RequestHandler;
use App\ApiHandlers\DefaultRequestHandler;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase{
    public function testGetHandler(){
        $app =  Application::instance();
        $handler = $app->getHandler('non_existen_request');
        $this->assertInstanceOf(DefaultRequestHandler::class, $handler);
        $handler = $app->getHandler('get_users');
        $this->assertInstanceOf(DefaultRequestHandler::class, $handler);
        $handler = $app->getHandler('api/get_users');
        $this->assertInstanceOf(GetUsersRequestHandler::class, $handler);
    }
}