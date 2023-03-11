<?php

include_once 'controllers/BaseController.php';
include_once 'services/DatabaseService.php';

class ChatController extends BaseController {
    // Endpoint for getting all messages in some room
    public function get() {
        $room = $_GET["room"];

        // Get the account from the database
        $result = DatabaseService::query("SELECT * FROM `chat` WHERE `room` = ?;", function ($stmt) use ($room) {
            $stmt->bind_param("s", $room);
        });

        echo json_encode($result);
    }

    // Endpoint for posting a message to some room
    public function post() {
        $by = $_POST["by"];
        $msg = $_POST["msg"];
        $room = $_POST["room"];

        // Insert the account into the database
        DatabaseService::query("INSERT INTO `chat` (`by`, `msg`, `room`) VALUES (?, ?, ?);", function ($stmt) use ($by, $msg, $room) {
            $stmt->bind_param("sss", $by, $msg, $room);
        });
    }
}