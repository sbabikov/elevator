<?php

namespace Elevator\Control;

/**
* Control panel interface
* @author Sergii Babikov
*/
interface ControlPanelInterface
{
    /**
    * Click "Up" button
    * 
    * @param int $floor
    * @return void
    */
    public function clickUpButton(int $floor): void;
    
    /**
    * Click "Down" button
    * 
    * @param int $floor
    * @return void
    */
    public function clickDownButton(int $floor): void;
    
    /**
    * Click "Floor" button
    * 
    * @param int $floor
    * @return void
    */
    public function clickFloorButton(int $floor): void;
    
    /**
    * Erase "Floor" button state in the state array
    * 
    * @param int $floor
    * @return void
    */
    public function eraseFloorButtons(int $floor): void;
    
    /**
    * Check if "Up" button is clicked
    * 
    * @param int $floor
    * @return boolean
    */
    public function isUpButtonClicked(int $floor): bool;
    
    /**
    * Check if "Down" button is clicked
    * 
    * @param int $floor
    * @return boolean
    */
    public function isDownButtonClicked(int $floor): bool;
    
    /**
    * Check if "Floor" button is clicked
    * 
    * @param int $floor
    * @return boolean
    */
    public function isFloorButtonClicked(int $floor): bool;
    
    /**
    * Get floor number where "Up" button is clicked
    * 
    * @param int $currentFloor
    * @return int
    */
    public function getUpNextFloor(int $currentFloor): int;
    
    /**
    * Get floor number where "Down" button is clicked
    * 
    * @param int $currentFloor
    * @return int
    */
    public function getDownNextFloor(int $currentFloor): int;
    
    /**
    * Get floor number where "any button is clicked
    * 
    * @param int $currentFloor
    * @return int
    */
    public function getAnyNearFloor(int $currentFloor): int;
    
    /**
    * Get next floor number from a queue
    * 
    * @param int $currentFloor
    * @param bool $isMoveUp direction
    * return int
    */
    public function getNextFloor(int $currentFloor, bool $isMoveUp): int;
}
