<?php

namespace Elevator\Sensor;

/**
* DoorSensorInterface
* @author Sergii Babikov
*/
interface DoorSensorInterface
{
    /**
    * The door is closed
    * @var int
    */
    const CLOSED_DOOR_STATE = 0;
    /**
    * The door is opened
    * @var int
    */
    const OPENED_DOOR_STATE = 1;
    
    /**
    * onOpen event implementation
    * 
    * @param mixed $callbackFunction
    */
    public function onOpen($callbackFunction): void;
    
    /**
    * onClose event implementation
    * 
    * @param mixed $callbackFunction
    */
    public function onClose($callbackFunction): void;
}
