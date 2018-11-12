<?php

namespace Elevator\Engine;

/**
* EngineInterface
* @author Sergii Babikov
*/
interface EngineInterface 
{
    /**
    * Engine state is stoped
    * @var int
    */
    const STOP_STATE = 0;
    /**
    * Engine rotor is rotated by clockwise
    * @var int
    */
    const ROTATE_CKW_STATE = 1;
    /**
    * Engine rotor is rotated by counter clockwise
    */
    const ROTATE_CCW_STATE = 2;
    
    /**
    * Constructor
    * 
    * @param float $power
    * @param int $speed
    * @return Engine
    */
    public function __construct(float $power, int $speed);
    
    /**
    * Stop the engine
    * 
    * @return void
    */
    public function stop(): void;
    
    /**
    * Rotate the engine rotor by clockwise
    * 
    * @return void
    */
    public function rotateClockwise(): void;
    
    /**
    * Rotate the engine rotor by counter clockwise
    * 
    * @return void
    */
    public function rotateCounterClockwise(): void;
    
    /**
    * Get the power engine
    * @return float
    */
    public function getPower(): float;
    
    /**
    * Get the speed engine
    * 
    * @return int
    */
    public function getSpeed(): int;
    
    /**
    * Get the current engine state
    * 
    * @return int
    */
    public function getState(): int;
}