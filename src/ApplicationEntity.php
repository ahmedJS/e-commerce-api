<?php
namespace EntitiesLibrary;

use EntitiesLibrary\EventsManager;
use EntitiesLibrary\Exceptions\EntityInitializationException;
use EntitiesLibrary\Exceptions\OperationDontExistException;

abstract class ApplicationEntity{
    public const REQUIRED_FIELDS = ["id"];
    abstract function __construct(
        DBAL $dbal,
        EventsManager $eventsManager,
        array $payload = []
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

    /**
     * @param array $self_vars
     */
    private function persist() : ApplicationEntity{

        $state = $this->getState();

        if ($this->isExist()) {
            $this->dbal->update($this->tableName,$state );
            $this->updateState($state);
        }
        else{
            $this->dbal->insert($this->tableName,$state);
        } 

        return $this;
    }


    function addState(array $state) : void{
        foreach(self::REQUIRED_FIELDS as $field){
            if (array_key_exists($field,$state))
            {
                $this->payload = $state ;
            }
            else
            {
                throw new EntityInitializationException("the `$field` field is required");
            }
        }
        
    }

    /**
     * @param array $items an associative array contain the payload of field
     * that needed to be changed internally in the entity only
     */
    function updateStateItems(array $items) : void{
        $final_result = [];
        
        // update the items and return array of whole with updated values

       $updatedItems = array_map(function($i , $v) use($items){
            if(isset($items[$i]))
            {
                return [$i => $items[$i]];
            }  
            return [$i => $v];
        },array_keys($this->payload),array_values($this->payload));

        // solve the problem of multidimintional array of the outcome 
        // and store it in `$final_result` array

        foreach($updatedItems as $key => $value ){
            if(is_array($value)){
                $final_result[array_key_first($value)] = end($value);
            }
        }

        // assert the outcome to the payload
        $this->payload =  $final_result;
    }
    
    function getState() : array{
        return $this->payload;
    }


    private function delete(string | array $condition = "default") : ApplicationEntity{

        $condition = is_array($condition) ? $condition : $this->id;
        
        $this->dbal->delete($this->tableName , $condition);
        
        return $this;
    }

    private function isExist() : bool{

        // the 1 number is for security reasons

        $id = $this->getId() ?? 1;

        return $this->dbal->get($id) ? true : false;

    }

    private function getId(){
        if(isset($this->getState()["id"])){
            return $this->getState()["id"];
        }else
        {
            throw new EntityInitializationException("the `id` field is required");
        }
    }

 
}
