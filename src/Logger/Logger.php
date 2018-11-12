<?php

namespace Elevator\Logger;

/**
* Logger class
* @author Sergii Babikov
*/
class Logger implements LoggerInterface
{
    /**
    * Display info message
    * 
    * @param string $message
    */
    public function info(string $message): void
    {
        echo $message . "\n";
    }
    
    /**
    * Display error message
    * 
    * @param string $message
    */
    public function error(string $message): void
    {
        echo '[' . date('H:i:s') . '] ERROR: ' . $message . "\n";
    }
}
?>
