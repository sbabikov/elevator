<?php

namespace Elevator\Control;

/**
* ControlPanel class
* @author Sergii Babikov
*/
class ControlPanel implements ControlPanelInterface
{
    /**
    * Total number of floors
    * @var int $floors
    */
    private $floors = 0;
    /**
    * "Up" button state array
    * @var array $floorUpCallState
    */
    private $floorUpCallState = [];
    /**
    * "Down" button state array
    * @var array $floorDownCallState
    */
    private $floorDownCallState = [];
    /**
    * Floor button state array
    * @var array $floorCallState
    */
    private $floorCallState = [];
    
    /**
    * Class constructor
    * 
    * @param int $floors
    * @return ControlPanel
    */
    public function __construct(int $floors)
    {
        $this->floors = $floors;
        $this->floorUpCallState = array_fill(1, $floors, 0);
        $this->floorDownCallState = array_fill(1, $floors, 0);
        $this->floorCallState = array_fill(1, $floors, 0);
    }
    
    /**
    * Click "Up" button
    * 
    * @param int $floor
    * @return void
    */
    public function clickUpButton(int $floor): void
    {
        $this->checkFloorRange($floor);
        $this->floorUpCallState[$floor] = 1;
    }
    
    /**
    * Click "Down" button
    * 
    * @param int $floor
    * @return void
    */
    public function clickDownButton(int $floor): void
    {
        $this->checkFloorRange($floor);
        $this->floorDownCallState[$floor] = 1;
    }
    
    /**
    * Click "Floor" button
    * 
    * @param int $floor
    * @return void
    */
    public function clickFloorButton(int $floor): void
    {
        $this->checkFloorRange($floor);
        $this->floorCallState[$floor] = 1;
    }
    
    /**
    * Erase "Floor" button state in the state array
    * 
    * @param int $floor
    * @return void
    */
    public function eraseFloorButtons(int $floor): void
    {
        $this->checkFloorRange($floor);
        $this->floorCallState[$floor] = 0;
        $this->floorUpCallState[$floor] = 0;
        $this->floorDownCallState[$floor] = 0;
    }
    
    /**
    * Check if "Up" button is clicked
    * 
    * @param int $floor
    * @return boolean
    */
    public function isUpButtonClicked(int $floor): bool
    {
        $this->checkFloorRange($floor);
        return (bool) $this->floorUpCallState[$floor];
    }
    
    /**
    * Check if "Down" button is clicked
    * 
    * @param int $floor
    * @return boolean
    */
    public function isDownButtonClicked(int $floor): bool
    {
        $this->checkFloorRange($floor);
        return (bool) $this->floorDownCallState[$floor];
    }
    
    /**
    * Check if "Floor" button is clicked
    * 
    * @param int $floor
    * @return boolean
    */
    public function isFloorButtonClicked(int $floor): bool
    {
        $this->checkFloorRange($floor);
        return (bool) $this->floorCallState[$floor];
    }
    
    /**
    * Get floor number where "Up" button is clicked
    * 
    * @param int $currentFloor
    * @return int
    */
    public function getUpNextFloor(int $currentFloor): int
    {
        $this->checkFloorRange($currentFloor);
        for ($floor = $currentFloor; $floor <= $this->floors; ++ $floor) {
            if ($this->floorUpCallState[$floor]) {
                return $floor;
            }
        }
        
        return 0;
    }
    
    /**
    * Get floor number where "Down" button is clicked
    * 
    * @param int $currentFloor
    * @return int
    */
    public function getDownNextFloor(int $currentFloor): int
    {
        $this->checkFloorRange($currentFloor);
        for ($floor = $currentFloor; $floor > 0; -- $floor) {
            if ($this->floorDownCallState[$floor]) {
                return $floor;
            }
        }
        
        return 0;
    }
    
    /**
    * Get floor number where "any button is clicked
    * 
    * @param int $currentFloor
    * @return int
    */
    public function getAnyNearFloor(int $currentFloor): int
    {
        $this->checkFloorRange($currentFloor);
        
        for ($floor = $currentFloor; $floor <= $this->floors; ++ $floor) {
            if ($this->floorDownCallState[$floor]) {
                return $floor;
            }
        }
        
        for ($floor = $currentFloor; $floor > 0; -- $floor) {
            if ($this->floorUpCallState[$floor]) {
                return $floor;
            }
        }
        
        $floor = $this->getUpNextFloor($currentFloor);
        if ($floor > 0) {
            return $floor;
        }
        
        $floor = $this->getDownNextFloor($currentFloor);
        if ($floor > 0) {
            return $floor;
        }
        
        return 0;
    }
    
    /**
    * Get next floor number from a queue
    * 
    * @param int $currentFloor
    * @param bool $isMoveUp direction
    * return int
    */
    public function getNextFloor(int $currentFloor, bool $isMoveUp): int
    {
        $this->checkFloorRange($currentFloor);

        if ($isMoveUp && $currentFloor <= $this->floors) {
            for ($floor = $currentFloor; $floor <= $this->floors; ++ $floor) {
                if ($this->floorCallState[$floor]) {
                    return $floor;
                }
            }
        } else {
            for ($floor = $currentFloor; $floor > 0; -- $floor) {
                if ($this->floorCallState[$floor]) {
                    return $floor;
                }
            }
        }
        
        return 0;
    }
    
    /**
    * Check floor number range
    * @param int $floor
    * @return void
    */
    private function checkFloorRange(int $floor): void
    {
        if ($floor > $this->floors || $floor < 1) {
            throw new \OutOfRangeException('Floor number is not correct!');
        }
    }
}
