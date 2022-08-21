<?php
use EntitiesLibrary\ApplicationEntity as Entity;
use EntitiesLibrary\DBAL;
use Brick\Event\EventDispatcher;
use EntitiesLibrary\EventsManager;

class UserEntity extends Entity{
    function __construct
    (
        string $tableName,
        DBAL $dbal,
         EventsManager $eventsManager,
    )

    {
        $this->tableName  = $tableName;
        $this->dbal = $dbal;
        $this->eventsManager = $eventsManager;
    }

}