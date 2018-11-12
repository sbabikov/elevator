<?php

namespace Elevator;

use \Elevator\{
    Logger\LoggerInterface,
    User\UserInterface,
    User\UserTaskInterface
};

/**
* Class Scenarion
* @author Sergii Babikov
*/
class Scenario
{
    /**
    * Amount tasks for each user
    * @var int
    */
    const USER_TASK_COUNT = 2;
    /**
    * Max value of seconds for "wait" tasks
    * @var int
    */
    const MAX_SEC_USER_WAITING = 7;
    
    /**
    * Amount of floors
    * @var int $floors
    */
    private $floors = 0;
    /**
    * Elevator object
    * @var ElevatorInterface $elevator
    */
    private $elevator;
    /**
    * Logger object
    * @var LoggerInterface $logger
    */
    private $logger;
    /**
    * User list
    * @var array $users
    */
    private $users = [];
    
    /**
    * Constructor
    * 
    * @param int $floors
    * @param ElevatorInterface $elevator
    * @param LoggerInterface $logger
    * @return Scenario
    */
    public function __construct(int $floors, ElevatorInterface $elevator, LoggerInterface $logger)
    {
        $this->floors = $floors;
        $this->logger = $logger;
        $this->elevator = $elevator;
    }
    
    /**
    * Add user to the scenario
    * 
    * @param UserInterface $user
    * @return void
    */
    public function addUser(UserInterface $user): void
    {
        $this->users[] = $user;
    }
    
    /**
    * Generate scenario
    * @return void
    */
    public function generate(): void
    {
        if (!count($this->users)) {
            throw new \BadMethodCallException('Users are absent! Please, add user to the scenario');
        }
        
        $this->logger->info(count($this->users) . ' user(s) are added to the scenario');
        
        foreach ($this->users as $user) {
            for ($j = 0; $j < $this::USER_TASK_COUNT; ++ $j) {
                $user->addWaitTask(rand(1, $this::MAX_SEC_USER_WAITING));
                $user->addGoTask(rand(1, $this->floors));
            }
        }
        
        $this->logger->info('The scenario has been genereted');
    }
    
    /**
    * Start the scenario
    * @return void
    */
    public function start(): void
    {
        if (!count($this->users)) {
            throw new \BadMethodCallException('Users are absent! Please, add user to the scenario');
        }
        
        $this->logger->info('Strarting the scenario ...');
        
        while (true) {
            $this->elevator->doStep();
            
            $taskCount = 0;
            
            foreach ($this->users as $user) {
                $currentTask = $user->getCurrentTask();
                
                if (empty($currentTask[0])) {
                    continue;
                }
                
                switch ($currentTask[0]) {
                    case UserTaskInterface::TASK_WAIT:
                        $user->waitOneSecond();
                        break;
                        
                    case UserTaskInterface::TASK_GO_TO_FLOOR:
                        $this->goToFloor($user);
                        break;
                }
                
                ++ $taskCount;
            }
            
            if ($taskCount === 0) {
                break;
            }
            
            sleep(1);
        }
    }
    
    /**
    * Go to  the floor
    * 
    * @param UserInterface $user
    * @return void
    */
    public function goToFloor(UserInterface $user): void
    {
        $currentTask = $user->getCurrentTask();
        $currentTaskName = $currentTask[0];
        $currentTaskFloor = $currentTask[1];
        $currentFloor = $user->getCurrentFloor();
        
        if ($currentTaskName !== UserTaskInterface::TASK_GO_TO_FLOOR) {
            throw new \BadMethodCallException('GoToFloor task mistake!');
        }
        
        $isMoveUp = $currentTaskFloor > $currentFloor ? true : false;
        $this->clickButton($user, $isMoveUp, $currentFloor, $currentTaskFloor);
        $this->enterIntoElevator($user, $currentFloor, $currentTaskFloor);
        $this->getOffElevator($user, $currentFloor, $currentTaskFloor);
    }
    
    /**
    * User clicks a "Up/Down" button
    * @param UserInterface $user
    * @param bool $isMoveUp
    * @param int $currentFloor
    * @param int $currentTaskFloor
    * @return void
    */
    private function clickButton(UserInterface $user, bool $isMoveUp, int $currentFloor, int $currentTaskFloor): void
    {
        if ($user->getState() !== UserInterface::CLICK_BUTTON_STATE) {
            return;
        }
        
        $name = '[' . $user->getName() . '] ';
        
        $this->logger->info($name . 'Task: ' . $currentFloor . ' -> ' . $currentTaskFloor);
        
        if ($currentTaskFloor === $currentFloor) {
            $user->clearCurrentTask();
            $this->logger->info($name . 'but I am alredy on ' . $currentTaskFloor . ' floor. My task has been completed.');
            return;
        }
        
        if ($isMoveUp) {
            if ($this->elevator->isUpButtonClicked($currentFloor)) {
                $this->logger->info($name . 'UpButton was already clicked. I am waiting the elevator');
            } else {
                $this->elevator->clickUpButton($currentFloor);
                $this->logger->info($name . 'I click on a UpButton. I am waiting the elevator');
            }
        } else {
            if ($this->elevator->isDownButtonClicked($currentFloor)) {
                $this->logger->info($name . 'DownButton was already clicked. I am waiting the elevator');
            } else {
                $this->elevator->clickDownButton($currentFloor);
                $this->logger->info($name . 'I click on a DownButton. I am waiting the elevator');
            }
        }
        
        $user->setState(UserInterface::WAITING_STATE);
    }
    
    /**
    * User enters to the elevator
    * @param UserInterface $user
    * @param int $currentFloor
    * @param int $currentTaskFloor
    * @return void
    */
    private function enterIntoElevator(UserInterface $user, int $currentFloor, int $currentTaskFloor): void
    {
        if ($user->getState() !== UserInterface::WAITING_STATE) {
            return;
        }
        
        if ($this->elevator->getState() === ElevatorInterface::STOP_OPEN_DOOR_STATE && $this->elevator->getCurrentFloor() === $currentFloor) {
            $user->setState(UserInterface::INSIDE_ELEVATOR_STATE);

            $name = '[' . $user->getName() . '] ';
            $this->logger->info($name . 'I enter the elevator. I\'m inside');
            
            if ($this->elevator->isFloorButtonClicked($currentTaskFloor)) {
                $this->logger->info($name . $currentTaskFloor . 'th floor button was already clicked.');
            } else {
                $this->elevator->clickFloorButton($currentTaskFloor);
                $this->logger->info($name . 'I click on the ' . $currentTaskFloor . 'th floor button.');
            }
            
            $user->setState(UserInterface::WAITING_FLOOR_STATE);
            $this->elevator->addUser($user);
        }
    }
    
    /**
    * User gets out from the elevator
    * @param UserInterface $user
    * @param int $currentFloor
    * @param int $currentTaskFloor
    * @return void
    */
    private function getOffElevator(UserInterface $user, int $currentFloor, int $currentTaskFloor): void
    {
        if ($user->getState() !== UserInterface::WAITING_FLOOR_STATE) {
            return;
        }
        
        if ($this->elevator->getState() === ElevatorInterface::STOP_OPEN_DOOR_STATE && $this->elevator->getCurrentFloor() === $currentTaskFloor) {
            if ($this->elevator->removeUser($user)) {
                $user->setState(UserInterface::CLICK_BUTTON_STATE);
                $name = '[' . $user->getName() . '] ';
                $this->logger->info($name . 'I got out of the elevator');
                $user->clearCurrentTask();
                $this->logger->info($name . 'My task has been completed');
            }
        }
    }
}
