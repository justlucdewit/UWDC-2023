<?php

// Allow all
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Import the Router class
include_once 'router.php';

// Import controllers
include_once 'controllers/RoomController.php';
include_once 'controllers/ChatController.php';

// Initialize database
include_once 'services/DatabaseService.php';

// Expect bodies to be JSON
$_POST = json_decode(file_get_contents('php://input'), true);

// Read config.json
$config = json_decode(file_get_contents('local.config.json'));
DatabaseService::connect($config->database->host, $config->database->username, $config->database->password, $config->database->database);

// Register a user GET route
$router = new Router();
$router->registerController('/api/rooms', new RoomController);
$router->registerController('/api/chats', new ChatController);

$router->registerRoute('GET', '/', function() {
    // Redirect to the frontend
    header('Location: /index.html');
});