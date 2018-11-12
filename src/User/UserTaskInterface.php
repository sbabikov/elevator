<?php

namespace Elevator\User;

/**
* UserTaskInterface
* @author Sergii Babikov
*/
interface UserTaskInterface
{
    /**
    * User is doing "wait" task
    * @var string 
    */
    const TASK_WAIT = 'wait';
    /**
    * User is doing "go to floor" task
    * @var string
    */
    const TASK_GO_TO_FLOOR = 'go';
    
    /**
    * Add "wait" task to the task list
    * @param int
    * @return void
    */
    public function addWaitTask(int $seconds): void;
    
    /**
    * Add "go" task to the task list
    * @param float
    * @return void
    */
    public function addGoTask(int $floor): void;
    
    /**
    * Get current user task
    * @return array
    */
    public function getCurrentTask(): array;
    
    /**
    * User has to wait one second
    * @return void
    */
    public function waitOneSecond(): void;
    
    /**
    * Clear current user task
    * @return void
    */
    public function clearCurrentTask(): void;
    
    /**
    * Set current user state
    * @param int
    * @return void
    */
    public function setState(int $newState): void;
    
    /**
    * Get current user state
    * @return int
    */
    public function getState(): int;
}