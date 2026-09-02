<?php

header("Content-Type: application/json");

try {
    require_once "../app/includes/dbconn.php";

    echo json_encode([
        "db-alive" => true
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "db-alive" => false
    ]);
}

