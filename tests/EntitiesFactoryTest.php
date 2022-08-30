<?php

use EntitiesLibrary\DBAL;
use EntitiesLibrary\EventsManager;
use \EntitiesLibrary\EntitiesFactory as Factory;

class EntitiesFactoryTest extends PHPUnit\Framework\TestCase {

    function setUp(): void
    {
        $this->dbal = new DBAL([
            "host" => "localhost",
            "user" => "root",
            "password" => "root",
            "dbName" => "ecommerce"
        ]);
    }
    // function testFetchUserEntity(){

    // }

    function testCreateNewUserEntity(){
        $this->dbal;
        $this->eventsManager = new EventsManager;

        $entitiesFactory = new Factory($this->dbal, $this->eventsManager);

        $user_entity = $entitiesFactory->CreateEntity(UserEntity::class,["id"=>3,"name" => "ahmed"],"users");

        $this->assertInstanceOf(UserEntity::class,$user_entity);
    }

}