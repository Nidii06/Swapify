<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends BaseController
{
    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
    }
    
    public function login(string $email, string $password): bool
    {
        $user = $this->user->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $this->session->set('user', [
                'id' => $user['id'],
                'name' => $user['full_name'],
                'email' => $user['email'],
                'role' => $user['role'] ?? 'user'
            ]);
            return true;
        }

        return false;
    }

    public function logout(): void
    {
        $this->session->destroy();
    }

    public function register(array $post): array
    {
        $errors = [];

        if ($this->user->findByEmail($post['email'])) {
            $errors[] = 'Email already exists';
            return ['success' => false, 'errors' => $errors];
        }

        if (empty($post['password']) || strlen($post['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters';
            return ['success' => false, 'errors' => $errors];
        }

        $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);

        if ($this->user->register($post)) {
            return ['success' => true];
        }

        $errors[] = 'Registration failed. Please try again.';
        return ['success' => false, 'errors' => $errors];
    }
}


