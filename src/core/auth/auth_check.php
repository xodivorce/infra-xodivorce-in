<?php
session_start();

if (!empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: ../test/test_user.php");
    exit;
} else {
    header("Location: ../../sign_in_email.php");
    exit;
}
?>