<?php

namespace EntitiesLibrary;
use Brick\Event\EventDispatcher;
use EntitiesLibrary\DBAL;

final class LibsFactory{

    private function __construct(){
    }

    static function getEventDispatcher(){
        return new EventDispatcher;
    }
    
    static function getDBAL(){
        return new DBAL;
    }
}