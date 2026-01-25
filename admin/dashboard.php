<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$admin_email = $_SESSION['admin']['email'] ?? 'Admin';

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Swapify</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/components/navigation.css">
    <link rel="stylesheet" href="../public/css/components/buttons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-container {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        .admin-sidebar {
            width: 250px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .admin-sidebar h2 {
            font-size: 24px;
            margin-bottom: 30px;
            text-align: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 20px;
        }

        .admin-sidebar ul {
            list-style: none;
        }

        .admin-sidebar li {
            margin-bottom: 15px;
        }

        .admin-sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .admin-sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .admin-sidebar a.active {
            background-color: rgba(255, 255, 255, 0.3);
            font-weight: bold;
        }

        .admin-content {
            flex: 1;
            padding: 30px;
        }

        .admin-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .admin-header h1 {
            color: #333;
            margin: 0;
        }

        .admin-header p {
            color: #666;
            margin: 5px 0 0 0;
        }

        .admin-user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e72 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .dashboard-card h3 {
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dashboard-card .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #2a5298;
        }

        .dashboard-card .stat-label {
            color: #666;
            font-size: 14px;
        }

        .dashboard-card a {
            color: #2a5298;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }

        .dashboard-card a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            background-color: #ff6b6b;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #ff5252;
        }

        .welcome-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .welcome-section h2 {
            color: #333;
            margin-bottom: 15px;
        }

        .welcome-section p {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="admin-container">
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <h2>
            <i class="fas fa-shield-alt"></i> Admin Panel
        </h2>
        <ul>
            <li>
                <a href="dashboard.php" class="active">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="users.php">
                    <i class="fas fa-users"></i> Users
                </a>
            </li>
            <li>
                <a href="skills.php">
                    <i class="fas fa-star"></i> Skills
                </a>
            </li>
            <li>
                <hr style="border: none; border-top: 1px solid rgba(255, 255, 255, 0.2); margin: 20px 0;">
            </li>
            <li>
                <a href="?logout=true">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="admin-content">
        <div class="admin-header">
            <div>
                <h1>Welcome to Admin Dashboard</h1>
                <p>Manage your Swapify platform</p>
            </div>
            <div class="admin-user-info">
                <div class="admin-user-avatar">
                    <?= strtoupper(substr($admin_email, 0, 1)) ?>
                </div>
                <div>
                    <strong><?= htmlspecialchars($admin_email) ?></strong>
                    <br>
                    <small>Administrator</small>
                </div>
                <a href="?logout=true" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>
                    <i class="fas fa-users" style="color: #667eea;"></i> Users
                </h3>
                <div class="stat-number">0</div>
                <div class="stat-label">Total Users</div>
                <a href="users.php">Manage Users →</a>
            </div>

            <div class="dashboard-card">
                <h3>
                    <i class="fas fa-star" style="color: #f39c12;"></i> Skills
                </h3>
                <div class="stat-number">0</div>
                <div class="stat-label">Total Skills</div>
                <a href="skills.php">Manage Skills →</a>
            </div>

            <div class="dashboard-card">
                <h3>
                    <i class="fas fa-layer-group" style="color: #27ae60;"></i> Categories
                </h3>
                <div class="stat-number">0</div>
                <div class="stat-label">Total Categories</div>
                <a href="skills.php">View Categories →</a>
            </div>
        </div>

        <div class="welcome-section">
            <h2>Administrator Dashboard</h2>
            <p>
                Welcome to the Swapify Admin Panel. From here you can manage users, skills, and all platform activities.
                <br><br>
                Use the navigation menu on the left to access different admin features.
            </p>
        </div>
    </div>
</div>

</body>
</html>
