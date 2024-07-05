<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require (__DIR__ . '/../vendor/autoload.php');

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Capsule\Manager as Capsule;
use Models\User;
use Models\GroupAssign;
use Models\Permission;
use Models\PermissionsAssign;
use Models\Group;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$config = require_once ('config.php');
$capsule = new Capsule();
$capsule->addConnection([
    'driver' => $config['db']['driver'],
    'host' => $config['db']['host'],
    'port' => $config['db']['port'],
    'database' => $config['db']['database'],
    'username' => $config['db']['username'],
    'password' => $config['db']['password'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

    $faker = Faker\Factory::create();
    if (Capsule::schema()->hasTable('users')) {
        echo ("Table 'users' already exist" . PHP_EOL);
    } else {
        Capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('uuid');
            $table->string('name');
            $table->timestamps();
        });
        for ($i = 0; $i < $config['init']['test_user_count']; $i++) {
            User::create([
                'uuid' => Uuid::uuid4(),
                'name' => $faker->name()
            ]);
        }
    }

    if (Capsule::schema()->hasTable('permissions')) {
        echo ("Table 'permissions' already exist" . PHP_EOL);
    } else {
        Capsule::schema()->create('permissions', function ($table) {
            $table->increments('id');
            $table->string('uuid');
            $table->string('alias');
            $table->mediumText('title');
            $table->timestamps();
        });
        $permissions = $config['init']['perms'];
        array_walk($permissions, function ($value, $index) {
            Permission::create([
                'uuid' => Uuid::uuid4(),
                'alias' => $value,
                'title' => $value,
            ]);
        });
    }

    if (Capsule::schema()->hasTable('permissions_assigns')) {
        echo ("Table 'permissions_assign' already exist" . PHP_EOL);
    } else {
        Capsule::schema()->create('permissions_assigns', function ($table) {
            $table->increments('id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();
        });
    }

    if (Capsule::schema()->hasTable('groups')) {
        echo ("Table 'groups' already exist" . PHP_EOL);
    } else {
        Capsule::schema()->create('groups', function ($table) {
            $table->increments('id');
            $table->string('uuid');
            $table->string('title');
            $table->boolean('invert')->default(false);
            $table->timestamps();
        });
        $groups = $config['init']['groups'];
        array_walk($groups, function ($value, $index) {
           $group = Group::create([
                'uuid' => Uuid::uuid4(),
                'title' => $index,
            ]);
            array_walk($value, function ($perm_title) use ($group) {
                $perm =  Permission::where('alias', $perm_title)->first();
                PermissionsAssign::create([
                    'group_id' => $group->id,
                    'permission_id' => $perm->id,
                ]);
            });
        });
        // Group::where('title', 'blocked')->update(['invert' => true]);
    }

    if (Capsule::schema()->hasTable('group_assigns')) {
        echo ("Table 'group_assigns' already exist" . PHP_EOL);
    } else {
        Capsule::schema()->create('group_assigns', function ($table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('group_id');
            $table->timestamps();
        });
        $user = User::find(1);
        GroupAssign::create([
            'user_id' => 1,
            'group_id' => Group::where('title', 'dev')->first()->id,
        ]);
    }

