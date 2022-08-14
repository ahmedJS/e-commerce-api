<?php
use EntitiesLibrary\ApplicationEntity as Entity;
class UserEntity extends Entity{
    function __construct($tableName)
    {
        $this->tableName  = $tableName;
    }

}