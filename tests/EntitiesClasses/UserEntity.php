<?php
use EntitiesLibrary\ApplicationEntity as Entity;
use EntitiesLibrary\DBAL;
use Brick\Event\EventDispatcher;
use EntitiesLibrary\EventsManager;

class UserEntity extends Entity{
    public $_tableName = "users";
    function __construct
    (
        DBAL $dbal,
        EventsManager $eventsManager,
        array $payload = []

    )

    {
        $this->tableName = $this->_tableName;
        $this->dbal = $dbal;
        $this->eventsManager = $eventsManager;
    }

}