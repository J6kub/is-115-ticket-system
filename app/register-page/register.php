<html>
<?php

$pwdHash = hash("sha256", $_POST["password"]);

echo $_POST["firstname"] . "<br>";
echo $_POST["lastname"] . "<br>";
echo $_POST["email"] . "<br>";
echo $pwdHash . "<br>";
echo $_POST["role"] . "<br>";

require "../includes/dbconn.php";

$sql = "INSERT INTO user
        (first_name, last_name, user_type, email, password_hash)
        VALUES (
            '{$_POST["firstname"]}',
            '{$_POST["lastname"]}',
            '{$_POST["role"]}',
            '{$_POST["email"]}',
            '$pwdHash'
        )";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

?>
</html>