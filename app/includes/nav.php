<nav>
    <a href=/app/register-page><button>Register page</button></a>
    <a href=/app/login-page><button>Login page</button></a>
    <a href=/><button>Main page</button></a>
    <a href=/app/admin-dashboard><button>Admin page</button></a>
    <a href=/app/user-dashboard><button>User page</button></a>
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