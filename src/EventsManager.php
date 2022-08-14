<?php
namespace EntitiesLibrary;
use PHPUnit\Framework\Constraint\Callback;
use Brick\Event\EventDispatcher;
use EntitiesLibrary\LibsFactory;
use Closure;

class EventsManager {
    private EventDispatcher $eventDispatcher;

    function __construct(){

        // register event dispature instance
        $this->eventDispatcher = LibsFactory::getEventDispatcher();

    }

    function registerListener(string $event,Closure $listener){
        $this->eventDispatcher->addListener($event,$listener);
    }

    /**
     * deprecated
     */
    // function dispatchEventWithMultiParams($event){
    //     $parameters = array_slice(func_get_args(),1);
    //     $this->eventDispatcher->dispatch($event,$parameters);
    // }

    function dispatch(string $event ,\stdClass &$class){
        $this->eventDispatcher->dispatch($event,$class);
    }
}