<?php

require_once __DIR__ . '/Session.php';

function setFlash($key, $message) {
    $session = Session::getInstance();
    $session->flash($key, $message);
}

function getFlash($key) {
    $session = Session::getInstance();
    return $session->flash($key);
}
