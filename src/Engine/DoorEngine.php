<?php

namespace Elevator\Engine;

/**
* DoorEngine class
* @author Sergii Babikov
*/
class DoorEngine extends Engine implements DoorEngineInterface
{
    /**
    * Open the door
    * 
    * @return void
    */
    public function open(): void
    {
        $this->rotateCounterClockwise();
    }
    
    /**
    * Close the door
    * 
    * @return void
    */
    public function close(): void
    {
        $this->rotateClockwise();
    }
}