<?php
require_once '../app/helpers/Session.php';

$session = Session::getInstance();

if (!$session->isLoggedIn()) {
    header("Location: ../public/login.php");
    exit;
}

if (!$session->isAdmin()) {
    header("Location: ../public/profile.php");
    exit;
}
