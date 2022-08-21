<?php

namespace EntitiesLibrary;
use EntitiesLibrary\LibsFactory;
use Brick\Event\EventDispatcher;
use PharIo\Manifest\Application;

class EntitiesFactory {
    function __construct(DBAL $dbal,EventDispatcher $eventDispatcher)
    {
        $this->dbal =$dbal;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $fullQualifiedClassName `namespace` and the `ApplicationEntity` class to be instantiated
     * @param array $payload an `Associative Array` That Contains At least the `id` field
     * @return ApplicationEntity
     */
    function getEntity(string $fullQualifiedClassName, array $payload) : ApplicationEntity {
        
        $entity = ($fullQualifiedClassName)($this->dbal,$this->eventDispatcher); 

        $entity->entityRuleMetaData = array_keys($payload);

        $entity->entityMetaData = $payload;
        
        return $entity;
    }
}
