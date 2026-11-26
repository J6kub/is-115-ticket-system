<html>
<?php
// Den gjør rå passord om til Hash, som gjør det vanskelig for hackere å finne passord til folk!
$pwdHash = hash("sha256", $_POST["password"]);


require "../includes/dbconn.php";
$firstname = trim(strip_tags($_POST["firstname"]));
$lastname = trim(strip_tags($_POST["lastname"]));
$role = $_POST["role"];
$email = $_POST["email"];

$sql = "INSERT INTO user
        (first_name, last_name, user_type_id, email, password_hash)
        VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssiss", $firstname, $lastname, $role, $email, $pwdHash);

if (mysqli_stmt_execute($stmt)) {
    echo "Nice, you registered yourself!";
} else {
    echo "Error: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);

?>
<h1 id='h1'></h1>
<script src="../reusables/redirect.js"></script>
<script>
    let h1 = document.getElementById("h1"); 
    ToMainTimeout(4, h1);

</script>
</html>

