<nav>
    <a href=../register-page><button>Register page</button></a>
    <a href=../login-page><button>Login page</button></a>
    <a href=../main-page><button>Main page</button></a>
    <a href=../admin-dashboard><button>Admin page</button></a>
    <a href=../user-dashboard><button>User page</button></a>
    <?php 
        session_start();
        if (isset($_SESSION["user"])) {
            foreach (get_object_vars($_SESSION["user"]) as $key => $value) {
                echo "<span>" . $key . ": " . $value . "</span>";
            }
        }
    ?>
</nav>

<style>
    nav {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    nav button {
        margin: 10px;
    }
    nav span {
        padding:10px;
        border: 2px solid black;

    }
</style>