<?php
  
namespace Elevator;

use Elevator\{
    Control\ControlPanel,
    Engine\ElevatorEngineInterface,
    Engine\DoorEngineInterface,
    Sensor\FloorSensorInterface,
    Sensor\DoorSensorInterface,
    Logger\LoggerInterface,
    User\UserInterface
};

/**
* Elevator class
* @author Sergii Babikov
*/
class Elevator extends ControlPanel implements ElevatorInterface
{
    /**
    * Elevator name
    * @var string
    */
    const ELEVATOR_NAME = '[ELEVATOR]';
    /**
    * Total amount of floors
    * @var int $floors
    */
    private $floors = 0;
    /**
    * Elevator engine object
    * @var ElevatorEngineInterface $elevatorEngine
    */
    private $elevatorEngine;
    /**
    * Door engine object
    * @var DoorEngineInterface $doorEngine
    */
    private $doorEngine;
    /**
    * Floor sensor object
    * @var FloorSensorInterface $floorSensor
    */
    private $floorSensor;
    /**
    * Door sensor object
    * @var DoorSensorInterface $doorSensor
    */
    private $doorSensor;
    /**
    * Logger object
    * @var LoggerInterface $logger
    */
    private $logger;
    /**
    * Current elevator state
    * @var int $state
    */
    private $state = self::STOP_CLOSE_DOOR_STATE;
    /**
    * Current elevator direction
    * @var int $direction
    */
    private $direction = self::NO_DIRECTION;
    /**
    * Current floor number
    * @var int $currentFloor
    */
    private $currentFloor = 1;
    /**
    * User list are inside of elevator
    * @var array $users
    */
    private $users = [];
    /**
    * Last log messsage
    * @var string $lastMessage
    */
    private $lastMessage = '';
    
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
    )
    {
        parent::__construct($floors);
        
        $this->floors = $floors;
        $this->currentFloor = $currentFloor;
        
        $this->elevatorEngine = $elevatorEngine;
        $this->doorEngine = $doorEngine;
        $this->floorSensor = $floorSensor;
        $this->doorSensor = $doorSensor;
        $this->logger = $logger;
    }
    
    /**
    * Do one step
    * @return void
    */
    public function doStep(): void
    {
        $targetFloor = $this->getTargetFloor();
        $currentFloor = $this->getCurrentFloor();
        $state = $this->getState();
        $direction = $this->getDirection();
        
        $this->info(
            self::ELEVATOR_NAME . ' ' . $currentFloor . 'th floor; Users: ' . $this->getUserCount()
        );

        if ($state === self::STOP_CLOSE_DOOR_STATE && $this->getUserCount() > 0) {
            $this->setState(self::MOVING_STATE);
            $this->setDirection($currentFloor < $targetFloor ? self::UP_DIRECTION : self::DOWN_DIRECTION);
        }
        
        if ($state === self::STOP_OPEN_DOOR_STATE) {
            $this->closeDoor();
            return;
        }
        
        if ($targetFloor === $currentFloor) {
            $this->openDoor();
            return;
        }
        
        if ($targetFloor > 0 && $state === self::STOP_CLOSE_DOOR_STATE && $direction === self::NO_DIRECTION) {
            $this->setState(self::MOVING_STATE);
            $this->setDirection($currentFloor < $targetFloor ? self::UP_DIRECTION : self::DOWN_DIRECTION);
            return;
        }
        
        if ($state === self::MOVING_STATE) {
            if ($direction === self::UP_DIRECTION) {
                $this->moveUp();
            } else {
                $this->moveDown();
            }
            return;
        }
    }
    
    /**
    * Get current elevator state
    * @return int
    */
    public function getState(): int
    {
        return $this->state;
    }
    
    /**
    * Set current elevator state
    * @param int $newState
    * @return void
    */
    public function setState(int $newState): void
    {
        $this->state = $newState;
    }
    
    /**
    * Get current elevator target floor
    * @return int
    */
    private function getTargetFloor(): int
    {
        $direction = $this->getDirection();
        $currentFloor = $this->getCurrentFloor();
        $targetFloor = 0;
        
        if (in_array($direction, [self::NO_DIRECTION, self::UP_DIRECTION]) && $currentFloor < $this->floors) {
            $targetFloor = $this->getNextFloor($currentFloor, true);
            $upNextFloor = $this->getUpNextFloor($currentFloor);
            
            $targetFloor = $upNextFloor > 0 && $upNextFloor < $targetFloor ? $upNextFloor : $targetFloor;
            
            if ($targetFloor > 0) {
                return $targetFloor;
            }
        } else {
            $targetFloor = $this->getNextFloor($currentFloor, false);
            $downNextFloor = $this->getDownNextFloor($currentFloor);
            $targetFloor = $downNextFloor > 0 && $downNextFloor < $targetFloor ? $downNextFloor : $targetFloor;
        }
        
        $targetFloor = $targetFloor > 0 ? $targetFloor : $this->getAnyNearFloor($currentFloor);
        
        return $targetFloor;
    }
    
    /**
    * Get current elevator floor
    * @return int
    */
    public function getCurrentFloor(): int
    {
        return $this->currentFloor;
    }
    
    /**
    * Display info message
    * @param string $message
    * @return void
    */
    private function info(string $message): void
    {
        if ($this->lastMessage === $message) {
            return;
        }
        
        $this->logger->info($message);
        $this->lastMessage = $message;
    }
    
    /**
    * Move up the elevator
    * @return void
    */
    private function moveUp(): void
    {
        $this->floorSensor->onChange(
            $this->getCurrentFloor(),
            true,
            function($currentFloor)
            {
                $this->setCurrentFloor($currentFloor);
                
                if ($currentFloor === $this->floors) {
                    $this->setDirection(self::DOWN_DIRECTION);
                }
            }
        );
        
        $this->elevatorEngine->up();
    }
    
    /**
    * Move down the elevator
    * @return void
    */
    private function moveDown(): void
    {
        $this->floorSensor->onChange(
            $this->getCurrentFloor(),
            false,
            function($currentFloor)
            {
                $this->setCurrentFloor($currentFloor);
                
                if ($currentFloor === 1) {
                    $this->setDirection(self::UP_DIRECTION);
                }
            }
        );
        
        $this->elevatorEngine->down();
    }
    
    /**
    * Set current elevator floor
    * @param int $currentFloor
    * @return void
    */
    private function setCurrentFloor(int $currentFloor): void
    {
        $this->currentFloor = $currentFloor;
        $this->setCurrentFloorForUsers($currentFloor);
    }
    
    /**
    * Open the elevator door
    * @return void
    */
    private function openDoor(): void
    {
        $this->doorSensor->onOpen(
            function()
            {
                $this->setState(self::STOP_OPEN_DOOR_STATE);
                $this->eraseFloorButtons($this->getCurrentFloor());
                $this->info(self::ELEVATOR_NAME . ' Door is opened');
                
                if ($this->getUserCount() === 0) {
                    $this->setDirection(self::NO_DIRECTION);
                }
            }
        );
        
        $this->doorEngine->open();
    }
    
    /**
    * Close the elevator door
    * @return void
    */
    private function closeDoor(): void
    {
        $this->doorSensor->onClose(
            function()
            {
                $this->setState(self::STOP_CLOSE_DOOR_STATE);
                $this->info(self::ELEVATOR_NAME . ' Door is closed');
                
                if ($this->getUserCount() === 0) {
                    $this->setDirection(self::NO_DIRECTION);
                }
            }
        );
        
        $this->doorEngine->open();
    }
    
    /**
    * Set current elevator direction
    * @param int $direction
    * @return void
    */
    public function setDirection(int $direction): void
    {
        $this->direction = $direction;
    }
    
    /**
    * Get current elevator direction
    * @return int
    */
    public function getDirection(): int
    {
        return $this->direction;
    }
    
    /**
    * Get user list
    * @return array
    */
    private function getUsers(): array
    {
        return $this->users;
    }
    
    /**
    * Add a user into the elevator
    * @param UserInterface $user
    * @return void
    */
    public function addUser(UserInterface $user): void
    {
        $this->users[] = $user;
    }
    
    /**
    * Remove user from user list
    * @param UserInterface $user
    * @return bool
    */
    public function removeUser(UserInterface $user): bool
    {
        for ($i = 0; $i < count($this->users); ++ $i) {
            if ($user === $this->users[$i]) {
                array_splice($this->users, $i, 1);
                return true;
            }
        }
        
        return false;
    }
    
    /**
    * Get user count
    * @return int
    */
    public function getUserCount(): int
    {
        return count($this->users);
    }
    
    /**
    * Set current floor for all inside elevator users
    * @param int $currentFloor
    * @return void;
    */
    private function setCurrentFloorForUsers(int $currentFloor): void
    {
        for ($i = 0; $i < count($this->users); ++ $i) {
            $this->users[$i]->setCurrentFloor($currentFloor);
        }
    }
}