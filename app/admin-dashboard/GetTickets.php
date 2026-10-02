<?php

header('Content-Type: application/json');

function ReturnJson($success, $message, $data, $code) {
    http_response_code($code);

    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);

    exit;
}

session_start();

if (!isset($_SESSION["user"])) {
    ReturnJson(false, "No access habibi", null, 401);
}

$user = get_object_vars($_SESSION["user"]);

if ($user["role"] == 1) {
    ReturnJson(false, "No access habibi", null, 403);
}

require "../includes/dbconn.php";


// =========================
// SEARCH
// =========================

$filters = ["FullName", "case_name", "case_desc"];

$conditions = [];
$params = [];
$types = "";

foreach ($filters as $filter) {

    if (isset($_GET[$filter]) && $_GET[$filter] !== '') {

        $conditions[] = "$filter LIKE ?";
        $params[] = "%" . $_GET[$filter] . "%";
        $types .= "s";
    }
}


// =========================
// PAGINATION
// =========================

$perPage = 25;

$page = isset($_GET['page'])
    ? max(1, (int)$_GET['page'])
    : 1;

$offset = ($page - 1) * $perPage;


// =========================
// COUNT
// =========================

$countQuery = "SELECT COUNT(*) AS total FROM case_overview";

if (!empty($conditions)) {
    $countQuery .= " WHERE " . implode(" OR ", $conditions);
}

$countStmt = $conn->prepare($countQuery);

if (!empty($params)) {
    $countStmt->bind_param($types, ...$params);
}

$countStmt->execute();

$countResult = $countStmt->get_result();
$totalResults = (int)$countResult->fetch_assoc()["total"];

$totalPages = ceil($totalResults / $perPage);


// =========================
// GET TICKETS
// =========================

$query = "SELECT * FROM case_overview";

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" OR ", $conditions);
}

$query .= " LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);

if (!empty($params)) {

    $types .= "ii";

    $params[] = $perPage;
    $params[] = $offset;

    $stmt->bind_param($types, ...$params);

} else {

    $stmt->bind_param("ii", $perPage, $offset);

}

$stmt->execute();

$result = $stmt->get_result();

$allShits = [];

while ($row = $result->fetch_assoc()) {
    $allShits[] = $row;
}


// =========================
// RESPONSE
// =========================

ReturnJson(
    true,
    "Nice",
    [
        "results" => $allShits,

        "pagination" => [
            "page" => $page,
            "per_page" => $perPage,
            "total_results" => $totalResults,
            "total_pages" => $totalPages
        ]
    ],
    200
);

?>