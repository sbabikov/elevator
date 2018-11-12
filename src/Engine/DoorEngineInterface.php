<?php

namespace Elevator\Engine;

/**
* DoorEngineInterface interface
* @author Sergii Babikov
*/
interface DoorEngineInterface
{
    /**
    * Open the door
    * 
    * @return void
    */
    public function open(): void;
    
    /**
    * Close the door
    * 
    * @return void
    */
    public function close(): void;
    
    /**
    * Stop the door engine
    * 
    * @return void
    */
    public function stop(): void;
}