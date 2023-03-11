<?php

include_once 'controllers/BaseController.php';
include_once 'services/DatabaseService.php';

class RoomController extends BaseController {
    public function get() {
        // Get the account from the database
        $result = DatabaseService::query("SELECT * FROM `room`;", function ($stmt) {});

        // Parse the json strings in the workers field
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]["workers"] = json_decode($result[$i]["workers"]);
        }

        echo json_encode($result);
    }

    public function post() {
        $name = $_POST["name"];
        $avatar = $_POST["avatar"];
        $roomToJoin = $_POST["room"];

        // Remove the account from all rooms
        $rooms = DatabaseService::query("SELECT * FROM `room`;", function ($stmt) {});
        for ($i = 0; $i < count($rooms); $i++) {
            $jsonString = $rooms[$i]["workers"];
            $workers = json_decode($jsonString);
            
            // Loop over workers
            for ($j = 0; $j < count($workers); $j++) {
                $worker = $workers[$j];
                
                // If the worker is the account, remove it
                if ($worker->name == $name) {
                    array_splice($workers, $j, 1);
                }
            }

            // Update the room in the database
            $jsonString = json_encode($workers);
            DatabaseService::query("UPDATE `room` SET `workers` = ? WHERE `name` = ?;", function ($stmt) use ($jsonString, $rooms, $i) {
                $stmt->bind_param("ss", $jsonString, $rooms[$i]["name"]);
            });

            // If the room is the room to join, add the account to it
            if ($rooms[$i]["name"] == $roomToJoin) {
                $workers[] = (object) [
                    "name" => $name,
                    "avatar" => $avatar
                ];

                // Update the room in the database
                $jsonString = json_encode($workers);
                DatabaseService::query("UPDATE `room` SET `workers` = ? WHERE `name` = ?;", function ($stmt) use ($jsonString, $rooms, $i) {
                    $stmt->bind_param("ss", $jsonString, $rooms[$i]["name"]);
                });
            }
        }
    }
}