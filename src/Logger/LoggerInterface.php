<?php

namespace Elevator\Logger;

/**
* LoggerInterface
* @author Sergii Babikov
*/
interface LoggerInterface
{
    /**
    * Display info message
    * 
    * @param string $message
    */
    public function info(string $message): void;
    
    /**
    * Display error message
    * 
    * @param string $message
    */
    public function error(string $message): void;
}
