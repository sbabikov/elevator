<?php

namespace Elevator\Sensor;

/**
* FloorSensor class
* @author Sergii Babikov
*/
class FloorSensor implements FloorSensorInterface
{
    /**
    * Current floor number
    * @var int $currentFloor
    */
    private $currentFloor = 0;
    /**
    * Total amount of floors
    * @var int $floors
    */
    private $floors = 0;
    
    /**
    * Constructor
    * 
    * @param int $floors
    * @return FloorSensor
    */
    public function __construct(int $floors)
    {
        $this->floors = $floors;
    }
    
    /**
    * onChange event implementation
    * 
    * @param int $currentFloor
    * @param bool $isMoveUp
    * @param mixed $callbackFunction
    * @return void
    */
    public function onChange(int $currentFloor, bool $isMoveUp, $callbackFunction): void
    {
        $this->checkFloorRange($currentFloor);
        
        // physical action
        if ($isMoveUp) {
            $currentFloor = ($currentFloor + 1) > $this->floors ? $this->floors : $currentFloor + 1;
        } else {
            $currentFloor = ($currentFloor - 1) < 1 ? 1 : $currentFloor - 1;
        }
        
        $this->currentFloor = $currentFloor;
        $callbackFunction($currentFloor);
    }
    
    /**
    * Check floor range
    * @param int $floor
    * @return void
    */
    private function checkFloorRange(int $floor): void
    {
        if ($floor > $this->floors || $floor < 1) {
            throw new \OutOfRangeException('Floor nubmer is not correct!');
        }
    }
}
