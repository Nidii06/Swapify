<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once '../app/core/Database.php';

// Get contacts from database
try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    $query = "SELECT id, name, email, subject, message, created_at FROM contacts ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $contacts = [];
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $query = "DELETE FROM contacts WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
        header("Location: contacts.php?success=deleted");
        exit;
    } catch (Exception $e) {
        // Handle error silently
    }
}

$success_message = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contacts - Swapify Admin</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/components/buttons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="../public/js/auth_sync.js" defer></script>
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

        .btn-view {
            background-color: #2a5298;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-view:hover {
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }

        .modal-header h2 {
            margin: 0;
            color: #333;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #666;
        }

        .close-btn:hover {
            color: #333;
        }

        .modal-body {
            color: #555;
            line-height: 1.6;
        }

        .modal-body p {
            margin-bottom: 15px;
        }

        .modal-body strong {
            color: #333;
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
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

            .table-container {
                overflow-x: auto;
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
                <a href="categories.php">
                    <i class="fas fa-layer-group"></i> Categories
                </a>
            </li>
            <li>
                <a href="contacts.php" class="active">
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
            <h1>
                <i class="fas fa-envelope"></i> Manage Contacts
            </h1>
        </div>

        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> Contact <?= ucfirst($success_message) ?> successfully!
            </div>
        <?php endif; ?>

        <div class="table-container">
            <?php if (!empty($contacts)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td><?= htmlspecialchars($contact['id']) ?></td>
                                <td><?= htmlspecialchars($contact['name']) ?></td>
                                <td><?= htmlspecialchars($contact['email']) ?></td>
                                <td><?= htmlspecialchars(substr($contact['subject'], 0, 30)) ?><?= strlen($contact['subject']) > 30 ? '...' : '' ?></td>
                                <td><?= date('M d, Y H:i', strtotime($contact['created_at'])) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn-view" onclick="viewContact(<?= $contact['id'] ?>, '<?= addslashes($contact['name']) ?>', '<?= addslashes($contact['email']) ?>', '<?= addslashes($contact['subject']) ?>', '<?= addslashes($contact['message']) ?>', '<?= $contact['created_at'] ?>')">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button type="button" class="btn-delete" onclick="if(confirm('Are you sure?')) window.location.href='contacts.php?action=delete&id=<?= $contact['id'] ?>'">
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
                    <p>No contacts found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Contact Details Modal -->
<div id="contactModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Contact Details</h2>
            <button type="button" class="close-btn" onclick="closeModal()">×</button>
        </div>
        <div class="modal-body">
            <p><strong>Name:</strong> <span id="modalName"></span></p>
            <p><strong>Email:</strong> <span id="modalEmail"></span></p>
            <p><strong>Date:</strong> <span id="modalDate"></span></p>
            <p><strong>Subject:</strong> <span id="modalSubject"></span></p>
            <p><strong>Message:</strong></p>
            <p style="background-color: #f5f5f5; padding: 15px; border-radius: 5px; white-space: pre-wrap;" id="modalMessage"></p>
        </div>
    </div>
</div>

<script>
function viewContact(id, name, email, subject, message, createdAt) {
    document.getElementById('modalName').textContent = name;
    document.getElementById('modalEmail').textContent = email;
    document.getElementById('modalSubject').textContent = subject;
    document.getElementById('modalMessage').textContent = message;
    document.getElementById('modalDate').textContent = new Date(createdAt).toLocaleString();
    document.getElementById('contactModal').classList.add('show');
}

function closeModal() {
    document.getElementById('contactModal').classList.remove('show');
}

window.onclick = function(event) {
    const modal = document.getElementById('contactModal');
    if (event.target == modal) {
        modal.classList.remove('show');
    }
}
</script>

</body>
</html>
