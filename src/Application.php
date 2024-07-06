<?php
namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\RequestHandler;
use App\ApiHandlers\DefaultRequestHandler;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;


class Application
{
    static private  $app;
    private Capsule $capsule;
    public static function instance(){
        if(empty(self::$app)) 
            self::$app = new Application();
        return self::$app;
    }
    private function __construct(){
        $config = require_once('config.php');
        $capsule = new Capsule();
        $capsule->addConnection([
            'driver'   => $config['db']['driver'],
            'host'     => $config['db']['host'],
            'database' => $config['db']['database'],
            'username' => $config['db']['username'],
            'password' => $config['db']['password'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'   => '',
        ]);
        $capsule->setEventDispatcher(new Dispatcher(new Container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
    public static function getHandler(string $url)/*:RequestHandler*/{
        $match = [];
        if(!preg_match('~api/([a-z_]*)~', $url, $match)){
            return new DefaultRequestHandler();
        }
        $class_name = $match[1];
        $class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $class_name)));
        $class_name = "App\\ApiHandlers\\{$class_name}RequestHandler";
        if(class_exists($class_name))
            return new $class_name();
        return new DefaultRequestHandler();
    }

    public function run(){
        return;
    }
    public function responseJson( array|object $data) : void{
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        return;
    }
}