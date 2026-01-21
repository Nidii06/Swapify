<?php
require_once '../app/helpers/Session.php';
require_once '../app/controllers/AuthController.php';

$auth = new AuthController();
$auth->logout();

header("Location: login.php");
exit;

