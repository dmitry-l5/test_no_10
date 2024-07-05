<?php
namespace App;

class ValidateResult{
    const FAIL = 0;
    const SUCCESS = 1;
    public $status = self::FAIL;
    public array $errors = [];
    public array $validated = [];
}