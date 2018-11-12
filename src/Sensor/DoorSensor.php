<?php

namespace Elevator\Sensor;

/**
* DoorSensor class
* @author Sergii Babikov
*/
class DoorSensor implements DoorSensorInterface
{
    /**
    * Last door sensor state
    * @var int
    */
    private $state = self::CLOSED_DOOR_STATE;
    
    /**
    * onOpen event implementation
    * 
    * @param mixed $callbackFunction
    */
    public function onOpen($callbackFunction): void
    {
        // physical action
        $this->state = self::OPENED_DOOR_STATE;
        $callbackFunction();
    }
    
    /**
    * onClose event implementation
    * 
    * @param mixed $callbackFunction
    */
    public function onClose($callbackFunction): void
    {
        // physical action
        $this->state = self::CLOSED_DOOR_STATE;
        $callbackFunction();
    }
}
