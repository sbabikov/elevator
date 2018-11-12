<?php

namespace Elevator;

use Elevator\{
    Engine\ElevatorEngineInterface,
    Engine\DoorEngineInterface,
    Sensor\FloorSensorInterface,
    Sensor\DoorSensorInterface,
    Logger\LoggerInterface,
    User\UserInterface
};

/**
* ElevatorInterface
* @author Sergii Babikov
*/
interface ElevatorInterface
{
    /**
    * Elevator with closed door is stoped
    * @var int
    */
    const STOP_CLOSE_DOOR_STATE = 0;
    /**
    * Elevator is moving
    * @var int
    */
    const MOVING_STATE          = 1;
    /**
    * Elevator with opened door is stoped
    * @var int
    */
    const STOP_OPEN_DOOR_STATE  = 2;
    /**
    * No direction
    * @var int
    */
    const NO_DIRECTION      = 0;
    /**
    * Moving up direction
    * @var int
    */
    const UP_DIRECTION      = 1;
    /**
    * Moving down direction
    * @var int
    */
    const DOWN_DIRECTION    = 2;
    
    /**
    * Constructor
    * 
    * @param int $floors
    * @param int $currentFloor
    * @param ElevatorEngineInterface $elevatorEngine
    * @param DoorEngineInterface $doorEngine
    * @param FloorSensorInterface $floorSensor
    * @param DoorSensorInterface $doorSensor
    * @param LoggerInterface $logger
    * @return Elevator
    */
    public function __construct(
        int $floors, 
        int $currentFloor,
        ElevatorEngineInterface $elevatorEngine, 
        DoorEngineInterface $doorEngine, 
        FloorSensorInterface $floorSensor, 
        DoorSensorInterface $doorSensor,
        LoggerInterface $logger
    );
    
    /**
    * Do one step
    * @return void
    */
    public function doStep(): void;
    
    /**
    * Set current elevator state
    * @param int $newState
    * @return void
    */
    public function setState(int $newState): void;
    
    /**
    * Get current elevator state
    * @return int
    */
    public function getState(): int;
    
    /**
    * Get current elevator floor
    * @return int
    */
    public function getCurrentFloor(): int;
    
    /**
    * Set current elevator direction
    * @param int $direction
    * @return void
    */
    public function setDirection(int $direction): void;
    
    /**
    * Get current elevator direction
    * @return int
    */
    public function getDirection(): int;
    
    /**
    * Get user count
    * @return int
    */
    public function getUserCount(): int;
    
    /**
    * Add a user into the elevator
    * @param UserInterface $user
    * @return void
    */
    public function addUser(UserInterface $user): void;
    
    /**
    * Remove user from user list
    * @param UserInterface $user
    * @return bool
    */
    public function removeUser(UserInterface $user): bool;
}
