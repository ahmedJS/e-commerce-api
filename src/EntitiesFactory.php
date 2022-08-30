<?php

namespace EntitiesLibrary;
class EntitiesFactory {
    function __construct(private DBAL $dbal,private EventsManager $eventsManager)
    {
        $this->dbal =$dbal;
        $this->eventsManager = $eventsManager;
    }

    /**
     * @param array $payload an `Associative Array` That Contains At least the `id` field
     * @return ApplicationEntity
     */
    function CreateEntity(string $fullQualifiedClassName, array $payload) : ApplicationEntity {
        $entity = new ($fullQualifiedClassName)
                        (
                            $this->dbal,
                            $this->eventsManager,
                            $payload
                        ); 
        return $entity;
    }

    function getEntity($fullQualifiedClassName,$id) : ApplicationEntity | null{
        $entity_data = $this->dbal->get($id);

        // if the data fetched successfully
        if($entity_data)
        {
            return 
             new ($fullQualifiedClassName)
                    (   $fullQualifiedClassName::tableName,
                        $this->dbal,$this->eventsManager,
                        $entity_data
                    ); 
        }

        // if not
        return null;
    }

}
