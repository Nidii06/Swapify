<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once '../app/models/Category.php';

$categoryModel = new Category();
$categories = $categoryModel->getAll() ?? [];

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $categoryModel->delete($id);
    header("Location: categories.php?success=deleted");
    exit;
}

$success_message = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Swapify Admin</title>
    <link rel="stylesheet" href="../public/css/style.css">
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
            position: fixed;
            height: 100vh;
            overflow-y: auto;
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
            margin-left: 250px;
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

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background-color: #1e3c72;
            color: white;
        }

        table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-edit {
            background-color: #2a5298;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            transition: background-color 0.3s;
        }

        .btn-edit:hover {
            background-color: #1e3c72;
        }

        .btn-delete {
            background-color: #ff6b6b;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s;
        }

        .btn-delete:hover {
            background-color: #ff5252;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .admin-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<div class="admin-container">
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <h2>
            <i class="fas fa-shield-alt"></i> Admin
        </h2>
        <ul>
            <li>
                <a href="dashboard.php">
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
                <a href="categories.php" class="active">
                    <i class="fas fa-layer-group"></i> Categories
                </a>
            </li>
            <li>
                <a href="contacts.php">
                    <i class="fas fa-envelope"></i> Contacts
                </a>
            </li>
            <li>
                <hr style="border: none; border-top: 1px solid rgba(255, 255, 255, 0.2); margin: 20px 0;">
            </li>
            <li>
                <a href="dashboard.php?logout=true">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="admin-content">
        <div class="admin-header">
            <div>
                <h1>
                    <i class="fas fa-layer-group"></i> Manage Categories
                </h1>
            </div>
        </div>

        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> Category <?= ucfirst($success_message) ?> successfully!
            </div>
        <?php endif; ?>

        <div class="table-container">
            <?php if (!empty($categories)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= htmlspecialchars($category['id']) ?></td>
                                <td><?= htmlspecialchars($category['name']) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="categories.php?action=edit&id=<?= $category['id'] ?>" class="btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn-delete" onclick="if(confirm('Are you sure?')) window.location.href='categories.php?action=delete&id=<?= $category['id'] ?>'">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">
                    <i class="fas fa-inbox" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                    <p>No categories found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
