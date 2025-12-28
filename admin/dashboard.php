<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit;
}

if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../public/profile.php");
    exit;
}
