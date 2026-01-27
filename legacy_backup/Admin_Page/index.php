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
    <title>Admin Dashboard - Library MS</title>
    <link rel="stylesheet" href="../Components/admin.css?v=<?php echo time(); ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <?php $current_page = 'dashboard'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <header class="top-bar">
            <div class="page-title">
                <h2>Dashboard</h2>
                <p>Welcome back, Admin!</p>
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
        </div>
    </main>

</body>

</html>