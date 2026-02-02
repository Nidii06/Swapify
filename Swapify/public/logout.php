<?php
require_once '../app/helpers/Session.php';
require_once '../app/controllers/AuthController.php';

$auth = new AuthController();
$auth->logout();

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logging out...</title>
</head>
<body>
  <script>
    (function () {
      try {
        localStorage.setItem('swapify:logout', String(Date.now()));
      } catch (e) {}

      try {
        if ('BroadcastChannel' in window) {
          new BroadcastChannel('swapify:auth').postMessage({ type: 'logout', at: Date.now() });
        }
      } catch (e) {}

      window.location.replace('login.php');
    })();
  </script>
</body>
</html>


