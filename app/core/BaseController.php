<?php

require_once __DIR__ . '/../helpers/Session.php';

abstract class BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = Session::getInstance();
    }

    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    protected function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function validateRequired($data, $fields)
    {
        $errors = [];
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
            }
        }
        return $errors;
    }
}

