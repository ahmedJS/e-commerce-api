<?php
namespace EntitiesLibrary;

use EntitiesLibrary\Exceptions\UnvalidSet;
use EntitiesLibrary\EventsManager;
use EntitiesLibrary\Exceptions\OperationDontExistException;

abstract class ApplicationEntity{
    
    abstract function __construct($tableName);

    protected $tableName;

    private EventsManager $EventsManager;

    /**
     * @var Array $entityRuleMetaData
     * it filled from the extending entity class used to identify the metadata
     * that ` must set in the extending class `
     */
    private Array $_entityRuleMetaData;

    function __set($name, $value)
    {
        switch($name) :

            // if the set value name is metadata

            case  "metadata" :

                $entityRuleMetaData = $this->getEntityRuleMetaData();

                // the value must be `array`
                if(!is_array($value))
                {
                    throw new 
                      UnvalidSet("the set data must be type of `array`");
                }else
                
                // otherwise loop into associative array of values and extract it as properties into class

                {
                    foreach($value as $field => $_value) {
                        $result = array_search($field , $entityRuleMetaData,true);
    
                        if($result !== false)$this->$field = $_value;
                    };
    
                }
                break;
            // if the set value name is entityRuleMetaData

            case "entityRuleMetaData" :
                
                // the value must be `array`

                if(!is_array($value))
                {
                    throw new 
                      UnvalidSet("the set data must be type of `array`");
                }else
                {
                    $this->setEntityRuleMetaData($value);
                }
                break;
            default : $this->$name = $value;
            break;
        endswitch;

    }

    function __call(string $name, array $arguments)
    {
        if(!method_exists(self::class,$name))
            throw new OperationDontExistException
            ("the operation method $name coulden't find ");
        
        // $this->$name($name,...$arguments);
    }

    function getEntityRuleMetaData() : array{
        return $this->_entityRuleMetaData ?? null;
    }
    function setEntityRuleMetaData($value){
        $this->_entityRuleMetaData = $value ;
    }
    
    function registerEventsManager(EventsManager $eventsManager) : void{
        $this->EventsManager = $eventsManager;
    }

    function isTheEventsManagerExist() : bool{
        return isset($this->EventsManager);
    }

    function persist(){
        $tableName = $this->tableName;
        $allEntityFields = $this->getAllEntityFields();
    }

    protected function getAllEntityFields() : array{
        return get_object_vars($this);
    }

}