<?php
require(__DIR__.'/../vendor/autoload.php');
use App\Application;
use App\Models\Group;
$app = Application::instance();
$groups = Group::get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API demo page</title>
    <style>
        *{
            font-family: 'Courier New', Courier, monospace;
        }
        .text-center{
            text-align: center;
        }
        .flex_1_4{
            display:flex;
            justify-content: stretch;
            align-items: start;
        }
        .panel{
            width: 25vw;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .panel > *{

        }
    </style>
</head>
<body>
    <h1 class="text-center">API demo page</h1>
    <div class="flex_1_4">
        <div class="panel">
            <div class="panel">
                <button type="button" onclick="get_users()">Get users list</button>
            </div>
            <div class="panel">
                <label for="">Group title : </label>
                <!-- <input type="text" id="group_title"> -->
                <select name="group_title" id="group_title">
                    <?php foreach($groups as $group):?>
                        <option value="<?=$group->title?>"><?=$group->title?></option>
                    <?php endforeach?>
                </select> 
                <button type="button" onclick="get_group_members()">Get group members</button>
            </div>
            <div class="panel">
                    <label for="user_id">User ID : </label>
                    <input type="number" name="user_id" id="user_id">
                    <label for="group_assign_title">Group title : </label>
                    <select name="group_title" id="group_assign_title">
                        <?php foreach($groups as $group):?>
                            <option value="<?=$group->title?>"><?=$group->title?></option>
                            <?php endforeach?>
                    </select>        
                    <button type="button" onclick="assign_group()">Assign user to group</button>
                    <button type="button" onclick="remove_group()">Remove user from group</button>
            </div>
            <div class="panel">
                <label for="user_perm_id">User ID : </label>
                <input type="number" id="user_perm_id">
                <button type="button" onclick="get_user_permissions()">Get user permissions</button>
            </div>
        </div>
        <pre id="board" class="">
      
        </pre>
    </div>
    <script>
        function get_user_permissions(){
            request('get_user_permissions', {'user_id':user_perm_id.value});
        }
        function remove_group(){
            request('remove_group', {'group':group_assign_title.value, 'user_id':user_id.value});
        }
        function assign_group(){
            request('assign_group', {'group':group_assign_title.value, 'user_id':user_id.value});
        }
        function get_users(){
            request('get_users');
        }
        function get_group_members(){
            alert('group : '+group_title.value);
            request('get_group_members', {'group':group_title.value});
        }

        function request(url, param = {} ){
            fetch('/api/'+url,{
                method:'POST',
                body:JSON.stringify(param),
            })
            .then(response=>response.json()).
            then(data=>{
                console.log(data);
                board.innerText = JSON.stringify(data, undefined, 4);
            });
        }
    </script>
</body>
</html>