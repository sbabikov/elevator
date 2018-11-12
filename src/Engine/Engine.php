<?php

namespace Elevator\Engine;

/**
* EngineInterface class
* @author Sergii Babikov
*/
class Engine implements EngineInterface
{
    /**
    * Power engine
    * @var float $power in kw
    */
    private $power = 0;
    
    /**
    * Speed engine
    * @var int $speed in rpm
    */
    private $speed = 0;
    
    /**
    * Engine current state
    * @var int $state
    */
    private $state = self::STOP_STATE;
    
    /**
    * Constructor
    * 
    * @param float $power
    * @param int $speed
    * @return Engine
    */
    public function __construct(float $power, int $speed)
    {
        $this->power = $power;
        $this->speed = $speed;
    }
    
    /**
    * Stop the engine
    * 
    * @return void
    */
    public function stop(): void
    {
        $this->state = self::STOP_STATE;
        // physical action
    }
    
    /**
    * Rotate the engine rotor by clockwise
    * 
    * @return void
    */
    public function rotateClockwise(): void
    {
        $this->state = self::ROTATE_CKW_STATE;
        // physical action
    }
    
    /**
    * Rotate the engine rotor by counter clockwise
    * 
    * @return void
    */
    public function rotateCounterClockwise(): void
    {
        $this->state = self::ROTATE_CCW_STATE;
        // physical action
    }
    
    /**
    * Get the power engine
    * 
    * @return float
    */
    public function getPower(): float
    {
        return $this->power;
    }
    
    /**
    * Get the speed engine
    * 
    * @return int
    */
    public function getSpeed(): int
    {
        return $this->speed;
    }
    
    /**
    * Get the current engine state
    * 
    * @return int
    */
    public function getState(): int
    {
        return $this->state;
    }
}