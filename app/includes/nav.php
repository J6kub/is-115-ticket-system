<nav>
    
    <a href=../main-page><button>Main page</button></a>
    
    
    <?php 
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION["user"])) {
            echo "<a href=../register-page><button>Register page</button></a>";
            echo "<a href=../login-page><button>Login page</button></a>";
        } else {
            
            if (get_object_vars($_SESSION["user"])["role"] == 1) {
                echo "<a href=../user-dashboard><button>User page</button></a>";
            } else {
                echo "<a href=../admin-dashboard><button>Admin page</button></a>";
            }


            echo '<div class="user-hover">';
            echo '<div class="user-icon">👤</div>';

            echo '<div class="user-popup">';
            echo '<strong>User information</strong>';

            foreach (get_object_vars($_SESSION["user"]) as $key => $value) {
                if ($key != "__PHP_Incomplete_Class_Name") {
                    echo '<div class="user-row">';
                    echo '<span>' . htmlspecialchars($key) . '</span>';
                    echo '<b>' . htmlspecialchars($value) . '</b>';
                    echo '</div>';
                }
                
            }
            echo "<a href='../includes/logout.php'><button>Logout</button></a>";

            echo '</div>';
            echo '</div>';
        }
    ?>
</nav>
<script>
    function nav_logout() {
        
    }
</script>
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

    .user-hover {
    position: relative;
    margin-left: 10px;
}

/* Cute pink user button */
.user-icon {
    width: 40px;
    height: 40px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #ffb6d9;
    color: #7a2852;

    border: 3px solid #fff;
    border-radius: 50%;

    font-size: 20px;
    cursor: pointer;

    box-shadow: 0 3px 10px rgba(255, 105, 180, 0.35);

    transition: 0.2s ease;
}

.user-icon:hover {
    transform: scale(1.12) rotate(-5deg);
    background: #ff9dcc;
    box-shadow: 0 5px 18px rgba(255, 105, 180, 0.5);
}

/* Pink bubble */
.user-popup {
    position: absolute;

    top: 50px;
    right: 0;

    min-width: 240px;
    padding: 16px;

    background: #fff0f7;
    color: #64213f;

    border: 3px solid #ffb6d9;
    border-radius: 18px;

    box-shadow:
        0 8px 25px rgba(214, 83, 139, 0.2),
        0 0 0 5px rgba(255, 182, 217, 0.15);

    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px) scale(0.96);

    transition: 0.18s ease;

    z-index: 999;
}

/* Tiny speech-bubble triangle */
.user-popup::before {
    content: "";

    position: absolute;
    top: -10px;
    right: 12px;

    width: 16px;
    height: 16px;

    background: #fff0f7;

    border-left: 3px solid #ffb6d9;
    border-top: 3px solid #ffb6d9;

    transform: rotate(45deg);
}

/* Show bubble */
.user-hover:hover .user-popup {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

/* Header */
.user-popup strong {
    display: block;

    margin-bottom: 10px;

    color: #d94f8a;
    font-size: 16px;

    text-align: center;
}

/* Individual attributes */
.user-row {
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 20px;
    padding: 7px 3px;

    border-top: 1px dashed #f3a8c9;

    font-size: 13px;
}

.user-row span {
    color: #b85b82;
    font-weight: 600;
}

.user-row b {
    color: #6d2949;
    text-align: right;
}

/* Little sparkle ✨ */
.user-popup strong::after {
    content: " ✨";
}
</style>