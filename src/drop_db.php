<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require(__DIR__.'/../vendor/autoload.php');

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Capsule\Manager as Capsule;

$config = require_once('config.php');

var_dump($config['db']['host'].':'.$config['db']['port'] );
$capsule = new Capsule();
$capsule->addConnection([
    'driver'   => $config['db']['driver'],
    'host'     => $config['db']['host'],
    'port'     => $config['db']['port'] ,
    'database' => $config['db']['database'],
    'username' => $config['db']['username'],
    'password' => $config['db']['password'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'   => '',
]);
$capsule->setAsGlobal();

Capsule::schema()->dropAllTables();
