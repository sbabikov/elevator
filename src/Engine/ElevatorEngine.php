<?php

namespace Elevator\Engine;

/**
* ElevatorEngine class
* @author Sergii Babikov
*/
class ElevatorEngine extends Engine implements ElevatorEngineInterface
{
    /**
    * Move up the elevator
    * @return void
    */
    public function up(): void
    {
        $this->rotateCounterClockwise();
    }
    
    /**
    * Move down the elevator
    * @return void
    */
    public function down(): void
    {
        $this->rotateClockwise();
    }
}