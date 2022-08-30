<?php

use Brick\Event\EventDispatcher;
use EntitiesLibrary\DBAL;
use EntitiesLibrary\EventsManager;
use EntitiesLibrary\Exceptions\EntityInitializationException;
use EntitiesLibrary\Exceptions\OperationDontExistException;
use PHPUnit\Framework\TestCase;
require "EntitiesClasses/UserEntity.php";

class ApplicationEntityTest extends TestCase{
    function setUp(): void
    {
        $this->DBAL = new DBAL([
            "host" => "localhost",
            "user" => "root",
            "password" => "root",
            "dbName" => "ecommerce"
        ]);
    }
    function testAddNewState() {
        $user_entity = new UserEntity($this->DBAL,new EventsManager);
        $user_entity->addState(["id"=>2,"name"=>"ahmed","age" => 22,"role" => "engineer"]);
        
        $this->assertSame(["id"=>2,"name"=>"ahmed","age" => 22,"role" => "engineer"],
                          $user_entity->getState());
    }
    function testUpdateState(){
        $user_entity = new UserEntity($this->DBAL,new EventsManager);
        $user_entity->addState(["id"=>6,"name"=>"ahmed","age" => 22,"role" => "engineer"]);
        $user_entity->updateStateItems(["name"=>"vekas"]);

        $this->assertSame(["id"=>6,"name"=>"vekas","age" => 22,"role" => "engineer"],
        $user_entity->getState());
    }

    function testThrowBadInitilizationException() {
        $user_entity = new UserEntity($this->DBAL,new EventsManager);

        $this->expectException(EntityInitializationException::class);

        $user_entity->addState(["name"=>"ahmed","age" => 22,"role" => "engineer"]);
    }
}

