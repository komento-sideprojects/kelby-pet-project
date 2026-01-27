<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login_page.php');
    exit();
}

$user_name = $_SESSION['user_name'] ?? 'Student';
$user_email = $_SESSION['user_email'] ?? 'student@library.com';

// Get initials for avatar
$initials = strtoupper(substr($user_name, 0, 2));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Library MS</title>
    <link rel="stylesheet" href="../Components/admin.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <?php $current_page = 'settings'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <header class="top-bar">
            <div class="page-title">
                <h2>Settings</h2>
                <p>Manage your account preferences.</p>
            </div>
            <div class="top-actions">
                <button class="action-btn" title="Notifications">
                    <i class="ph-bold ph-bell"></i>
                </button>
                <button class="action-btn" title="Search">
                    <i class="ph-bold ph-magnifying-glass"></i>
                </button>
            </div>
        </header>

        <!-- Dynamic Content Area -->
        <div class="content-container">
            <div
                style="background: white; padding: 2rem; border-radius: 16px; box-shadow: var(--shadow-sm); text-align: center; color: var(--text-muted);">
                <i class="ph-duotone ph-gear" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <h3>Account Settings</h3>
                <p>Settings configuration not available yet.</p>
            </div>
        </div>
    </main>

</body>

</html>