<?php

ini_set('display_errors', 0);

use Elevator\{
    Elevator,
    Scenario,
    Logger\Logger,
    User\User,
    Engine\ElevatorEngine,
    Engine\DoorEngine,
    Control\ControlPanel,
    Sensor\DoorSensor,
    Sensor\FloorSensor
};

require_once __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config/config.php';

$logger = new Logger();

$elevatorEngine = new ElevatorEngine(10000, 20000);
$doorEngine = new DoorEngine(10, 15000);
$doorSensor = new DoorSensor();
$floorSensor = new FloorSensor($config['floors']);

$elevator = new Elevator(
    $config['floors'],
    rand(1, $config['floors']),
    $elevatorEngine,
    $doorEngine,
    $floorSensor,
    $doorSensor,
    $logger
);

$scenarioObj = new Scenario($config['floors'], $elevator, $logger);

// Add users to the scenario
for ($i = 1; $i <= $config['users']; ++ $i) {
    $scenarioObj->addUser(
        new User(
            'USER ' . $i,
            rand(1, $config['floors'])
        )
    );
}

try {
    // Generate the scenario
    $scenarioObj->generate();
    // Start the scenario
    $scenarioObj->start();
} catch (\Exception $e) {
    $logger->error($e->getMessage());
}