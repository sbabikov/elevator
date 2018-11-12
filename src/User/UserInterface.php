<?php

namespace Elevator\User;

use Elevator\Logger\LoggerInterface;

/**
* UserInterface
* @author Sergii Babikov
*/
interface UserInterface
{
    /**
    * User must click on button
    * @var int
    */
    const CLICK_BUTTON_STATE = 0;
    /**
    * User is waiting the elevator
    * @var int
    */
    const WAITING_STATE = 1;
    /**
    * User is inside of elevator
    * @var int
    */
    const INSIDE_ELEVATOR_STATE = 2;
    /**
    * User is waiting target floor
    * @var int
    */
    const WAITING_FLOOR_STATE = 3;
    
    /**
    * Constructor
    * 
    * @param string $name
    * @param int $currentFloor
    * @return User
    */
    public function __construct(string $name, int $currentFloor);
    
    /**
    * Get user name
    * @return string
    */
    public function getName(): string;
    
    /**
    * Set current floor number
    * @param int $currentFloor
    * @return void;
    */
    public function setCurrentFloor(int $currentFloor): void;
    
    /**
    * Get current floor number
    * @return int
    */
    public function getCurrentFloor(): int;
}