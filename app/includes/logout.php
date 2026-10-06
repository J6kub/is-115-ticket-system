<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION["user"]);
?>
<script>
    window.onload = () => {setTimeout(() => {
        rawr();   
    }, 1000);}

    function rawr() {
        location.href = "../main-page/";
    }
</script>