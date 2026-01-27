<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Not authorized
    header('Location: ../login_page.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Library MS</title>
    <link rel="stylesheet" href="../Components/admin.css?v=<?php echo time(); ?>">
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
                <p>System configuration.</p>
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
            <!-- Content will go here -->
            <div
                style="background: white; padding: 2rem; border-radius: 16px; box-shadow: var(--shadow-sm); text-align: center; color: var(--text-muted);">
                <i class="ph-duotone ph-gear" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <h3>Settings</h3>
                <p>Configure application settings.</p>
            </div>
        </div>
    </main>

</body>

</html>