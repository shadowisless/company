<?php
session_start();
session_destroy();

if (isset($_GET['role']) && $_GET['role'] === 'admin') {
    header("Location: login.php");
} else {
    header("Location: loginuser.php");
}
exit();
?>
