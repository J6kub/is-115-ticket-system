<html>
    <?php 
        
        echo $_POST["email"] . "<br>";
        echo $_POST["password"] . "<br>";

        require "../includes/dbconn.php";
        require "../includes/classes/user.php";

        $pwdHash = hash("sha256", $_POST["password"]);

        $sql = "SELECT * FROM user
            WHERE email = '{$_POST["email"]}'
            AND password_hash = '$pwdHash'
            LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            session_start();
            $row = $result->fetch_assoc();

            echo "USER GOOD!!!<br>";
            $user = new User($row);
            $user->echoit();
            $_SESSION["user"] = $user;
        } else {

            echo "NO USER FOUND";

        }
    ?>
</html>