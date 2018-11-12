<?php

namespace Elevator\Engine;

/**
* ElevatorEngineInterface
* @author Sergii Babikov
*/
interface ElevatorEngineInterface
{
    /**
    * Move up the elevator
    * @return void
    */
    public function up(): void;
    
    /**
    * Move down the elevator
    * @return void
    */
    public function down(): void;
    
    /**
    * Stop the elevator engine
    * @return void
    */
    public function stop(): void;
}