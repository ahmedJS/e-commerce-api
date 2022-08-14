<?php

use EntitiesLibrary\Exceptions\OperationDontExistException;
use PHPUnit\Framework\TestCase;
require "EntitiesClasses/UserEntity.php";

class ApplicationEntityTest extends TestCase{
    function testSettingMetaDataBasedOnEntityRules()
    {
    $user_entity = new UserEntity("users");

    // rules of db field set on an entity
    $user_entity->entityRuleMetaData = ["id","name","address","postalCode"];

    $user_entity->metadata = array("id"=>15,"name"=>"ahmed",
                                    "address"=>"iraq/baghdad",
                                    "postalCode"=>964,
                                    "userName" => "ahmedJS");

    $this->assertEquals($user_entity->id, 15);
    $this->assertNotContains("userName", (array) $user_entity);

    }

    function testThrowingOperationDontExistException(){
        $user_entity = new UserEntity("users");
        
        $this->expectException(OperationDontExistException::class);

        $user_entity->somemethod();
    }
    function testConvertedEntityToArrayisPure(){
        $user_entity = new UserEntity("users");

        // rules of db field set on an entity
        $user_entity->entityRuleMetaData = ["id","name","address","postalCode"];
    
        $array = array("id"=>15,"name"=>"ahmed",
        "address"=>"iraq/baghdad",
        "postalCode"=>964,
        );

        $user_entity->metadata = $array;
        
        $this->assertEquals($array, get_object_vars($user_entity));
        
    
    }

    
}

