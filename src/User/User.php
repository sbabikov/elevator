<?php

namespace Elevator\User;

use Elevator\Logger\LoggerInterface;

/**
* User class
* @author Sergii Babikov
*/
class User implements UserInterface, UserTaskInterface 
{
    /**
    * User name
    * @var string $name
    */
    private $name = '';
    /**
    * Current floor number
    * @var int $currentFloor
    */
    private $currentFloor = 0;
    /**
    * Current user task
    * @var array $currentTask
    */
    private $currentTask = [];
    /**
    * Current user state
    * @var int $currentState
    */
    private $currentState = self::CLICK_BUTTON_STATE;
    /**
    * User task list
    * @var array $tasks
    */
    private $tasks = [];
    
    /**
    * Constructor
    * 
    * @param string $name
    * @param int $currentFloor
    * @return User
    */
    public function __construct(string $name, int $currentFloor)
    {
        $this->name = $name;
        $this->currentFloor = $currentFloor;
    }
    
    /**
    * Get user name
    * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
    * Set current floor number
    * @param int $currentFloor
    * @return void;
    */
    public function setCurrentFloor(int $currentFloor): void
    {
        $this->currentFloor = $currentFloor;
    }
    
    /**
    * Get current floor number
    * @return int
    */
    public function getCurrentFloor(): int
    {
        return $this->currentFloor;
    }
    
    /**
    * Add "wait" task to the task list
    * @param int
    * @return void
    */
    public function addWaitTask(int $seconds): void
    {
        $this->tasks[] = [$this::TASK_WAIT, $seconds];
    }
    
    /**
    * Add "go" task to the task list
    * @param float
    * @return void
    */
    public function addGoTask(int $float): void
    {
        $this->tasks[] = [$this::TASK_GO_TO_FLOOR, $float];
    }
    
    /**
    * Get current user task
    * @return array
    */
    public function getCurrentTask(): array
    {
        if (empty($this->currentTask)) {
            $this->currentTask = array_shift($this->tasks);
        }
        
        return $this->currentTask ?? [];
    }
    
    /**
    * User has to wait one second
    * @return void
    */
    public function waitOneSecond(): void
    {
        if (!empty($this->currentTask) && $this->currentTask[0] === $this::TASK_WAIT) {
            -- $this->currentTask[1];
            
            if (!$this->currentTask[1]) {
                $this->currentTask = null;
            }
            
            return;
        }
        
        throw new \BadMethodCallException('Waiting task mistake!');
    }
    
    /**
    * Clear current user task
    * @return void
    */
    public function clearCurrentTask(): void
    {
        $this->currentTask = null;
    }
    
    /**
    * Set current user state
    * @param int
    * @return void
    */
    public function setState(int $newState): void
    {
        $this->currentState = $newState;
    }
    
    /**
    * Get current user state
    * @return int
    */
    public function getState(): int
    {
        return $this->currentState;
    }
}