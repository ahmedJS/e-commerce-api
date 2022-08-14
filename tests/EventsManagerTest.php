<?php
use PHPUnit\Framework\TestCase;
use EntitiesLibrary\EventsManager ;

use function PHPUnit\Framework\assertContains;

class EventsManagerTest extends TestCase{
    function testModifyClassByReference(){
        $em = new EventsManager();

        $em->registerListener("list",function(\stdClass $class){
            $class->newProperty = "something";
        });

        $class = new stdClass();
        $em->dispatch("list",$class);

        $this->assertArrayHasKey("newProperty",(array)$class);
    }
}