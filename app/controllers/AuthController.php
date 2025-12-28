<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    
    private $user;

    public function __construct() {
        $this->user = new User();
    }
    
    public function login($email, $password) {
    $user = $this->user->findByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['full_name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        return true;
    }

    return false;
}


    public function logout() {
        session_start();
        session_destroy();
    }

   public function register($post) {
    if ($this->user->findByEmail($post['email'])) {
        echo "Email already exists";
        return;
    }

    $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);

    $this->user->register($post);

    header("Location: login.php");
    exit;
}

}


