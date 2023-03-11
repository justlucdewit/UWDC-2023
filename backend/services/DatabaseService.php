<?php
class DatabaseService {
    static $conn = null;


    static public function connect($serverName, $username, $password, $database) {
        self::$conn = new mysqli($serverName, $username, $password, $database);
    }

    static public function query($query, $func) {
        // Execute query
        $stmt = self::$conn->prepare($query);

        // Do stuff with the statement
        $func($stmt);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result instanceof mysqli_result) {
            $ret = [];

            foreach ($result as $key => $val) {
                $ret[$key] = $val;
            }

            return $ret;
        }
    }
}