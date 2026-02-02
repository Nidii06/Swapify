<?php
session_start();

// If already logged in as admin, redirect to dashboard
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simple admin credentials (you can change these)
    // For production, store these securely in database with hashed passwords
    $admin_email = 'admin@swapify.com';
    $admin_password = 'admin123'; // Change this!

    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION['admin'] = [
            'email' => $email,
            'login_time' => date('Y-m-d H:i:s')
        ];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = 'Invalid email or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Swapify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="1200" height="600" fill="url(%23grid)" /></svg>');
            pointer-events: none;
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 50px 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .admin-icon {
            font-size: 60px;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border-radius: 50%;
            box-shadow: 0 10px 30px rgba(30, 60, 114, 0.3);
        }

        .login-header h1 {
            color: #1e3c72;
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            background-color: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1e3c72;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
        }

        .error-message {
            background-color: #fff3cd;
            color: #856404;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #ff6b6b;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .error-message i {
            font-size: 18px;
            color: #ff6b6b;
        }

        .submit-btn {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(30, 60, 114, 0.2);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 60, 114, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 14px;
        }

        .login-footer a {
            color: #1e3c72;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .info-box {
            background: linear-gradient(135deg, #f0f4ff 0%, #f5e6ff 100%);
            border-left: 4px solid #1e3c72;
            padding: 15px;
            border-radius: 8px;
            margin-top: 25px;
            font-size: 13px;
            color: #444;
        }

        .info-box strong {
            color: #1e3c72;
            display: block;
            margin-bottom: 8px;
        }

        .info-box code {
            background-color: rgba(30, 60, 114, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
            color: #1e3c72;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-container">
        <div class="login-header">
            <div class="admin-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1>Admin Panel</h1>
            <p>Swapify Administration</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Email Address
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="Enter your admin email"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Enter your password"
                    required
                >
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-sign-in-alt"></i> Login to Admin Panel
            </button>
        </form>

        <div class="login-footer">
            <a href="../public/index.php">← Back to Swapify</a>
        </div>
    </div>
</div>

</body>
</html>
