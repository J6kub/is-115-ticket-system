<?php 
    function ReturnJson($success,$message,$data) {
        http_response_code(404);
        echo json_encode([
            "success" => $success,
            "message" => $message,
            "data" => json_encode($data);
        ]);
        exit;
    }

    session_start();
    header('Content-Type: application/json');

    require "../includes/dbconn.php";

    $result = $conn->query("SELECT * FROM case_overview where case_id=" . $_GET["id"]);
    $cases = array();
    while($case = $result->fetch_assoc()) {
        array_push($cases,$case);
    }

    // offset in query - Pagination
    // something bs rawr 

    
    ?>