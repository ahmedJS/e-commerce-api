<?php
namespace EntitiesLibrary;

use Brick\Event\EventDispatcher;
use EntitiesLibrary\EventsManager;
use EntitiesLibrary\Exceptions\UnvalidSet;
use EntitiesLibrary\Exceptions\OperationDontExistException;
use ReflectionClass;
use ReflectionObject;
use ReflectionProperty;

abstract class ApplicationEntity{
    
    abstract function __construct(
        string $tableName,
        DBAL $dbal,
        EventsManager $eventsManager,
    );

    protected $tableName;

    protected EventsManager $eventsManager;

    protected DBAL $dbal;

   protected array $payload;

    function __call(string $name, array $arguments)
    {
        // check if the method whether existed or not this this abstact class
        if(!method_exists(self::class,$name))
            throw new OperationDontExistException
            ("the operation method $name coulden't find ");
    
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

    /**
     * @param array $self_vars
     */
    private function persist(array $self_vars) : ApplicationEntity{

        $tableName = $this->tableName;

        if ($this->isExist()) {
            $this->dbal->update($tableName, $self_vars);
            $this->updateState($self_vars);
        }
        else{
            $this->dbal->insert($tableName,$self_vars);
        } 

        return $this;
    }

    /**
     * @param array $payload the updated data of the entity
     */
    private function updateState(array $payload){
        foreach($payload as $field => $value)
        {
            $this->$field = $value;
        }
    }


    // under maintainance
    function getMembers(){
        $reflection_class = new ReflectionObject($this);
        return $reflection_class->getProperties();
   
    }

    private function delete(string | array $condition = "default") : ApplicationEntity{

        $condition = is_array($condition) ? $condition : $this->id;
        
        $this->dbal->delete($this->tableName , $condition);
        
        return $this;
    }

    private function isExist() : bool{
        return $this->dbal->get($this->id) ? true : false;
    }
}















// function __set($name, $value)
// {
//     switch($name) :

//         // if the set value name is metadata

//         case  "metadata" :

//             $entityRuleMetaData = $this->getEntityRuleMetaData();

//             // the value must be `array`
//             if(!is_array($value))
//             {
//                 throw new 
//                   UnvalidSet("the set data must be type of `array`");
//             }else
            
//             // otherwise loop into associative array of values and extract it as properties into class

//             {
//                 foreach($value as $field => $_value) {
//                     $result = array_search($field , $entityRuleMetaData,true);

//                     if($result !== false)$this->$field = $_value;
//                 };

//             }
//             break;
//         // if the set value name is entityRuleMetaData

//         case "entityRuleMetaData" :
            
//             // the value must be `array`

//             if(!is_array($value))
//             {
//                 throw new 
//                   UnvalidSet("the set data must be type of `array`");
//             }else
//             {
//                 $this->setEntityRuleMetaData($value);
//             }
//             break;
//         default : $this->$name = $value;
//         break;
//     endswitch;

// }
