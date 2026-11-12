
<?php
require "dbconn.php";

function GetStatuses() {
    global $conn;

    $q = "SELECT * FROM statuses";
    $res = $conn->query($q);

    return $res;
}

function PrintSelectStatuses($selected = 1) {
    $stats = GetStatuses();

    $html = '';

    while ($row = $stats->fetch_assoc()) {
        $id = htmlspecialchars($row["id"]);
        $name = htmlspecialchars($row["name"]);

        $isSelected = ($selected == $row["id"]) ? "selected" : "";

        $html .= "<option value='$id' $isSelected>$name</option>";
    }

    $html .= '';

    echo $html;
}


?>
