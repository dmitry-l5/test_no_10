<?php
namespace App;

abstract class RequestHandler{

    public abstract function validate(object $input):?object;
    public abstract function run(object $input = null);

}
