<?php
namespace EntitiesLibrary\Exceptions;

class EntityInitializationException extends \Exception{
    function __construct($message)
    {
        $this->message = "bad initilization : $message";
        parent::__construct($this->message);
    }
}