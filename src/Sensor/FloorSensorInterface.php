<?php

namespace Elevator\Sensor;

/**
* FloorSensorInterface
* @author Sergii Babikov
*/
interface FloorSensorInterface
{
    /**
    * Constructor
    * 
    * @param int $floors
    * @return FloorSensor
    */
    public function __construct(int $floors);
    
    /**
    * onChange event implementation
    * 
    * @param int $currentFloor
    * @param bool $isMoveUp
    * @param mixed $callbackFunction
    * @return void
    */
    public function onChange(int $currentFloor, bool $isMoveUp, $callbackFunction): void;
}
