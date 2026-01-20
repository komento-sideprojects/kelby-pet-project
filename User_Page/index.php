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
    <title>Student Dashboard - Library MS</title>
    <link rel="stylesheet" href="../Components/admin.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-section">
            <i class="ph-bold ph-books logo-icon"></i>
            <span class="logo-text">LMS Student</span>
        </div>

        <ul class="nav-links">
            <li class="nav-item">
                <a href="#" class="active">
                    <i class="ph-duotone ph-house"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="ph-duotone ph-book-open"></i>
                    <span>My Books</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="ph-duotone ph-clock-counter-clockwise"></i>
                    <span>History</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="ph-duotone ph-heart"></i>
                    <span>Favorites</span>
                </a>
            </li>
            <li class="nav-item" style="margin-top: auto;">
                <a href="#">
                    <i class="ph-duotone ph-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../logout.php" style="color: #ef4444;">
                    <i class="ph-duotone ph-sign-out"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>

        <div class="user-profile">
            <div class="avatar" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
                <?php echo $initials; ?>
            </div>
            <div class="user-info">
                <h4>
                    <?php echo htmlspecialchars($user_name); ?>
                </h4>
                <p>
                    <?php echo htmlspecialchars($user_email); ?>
                </p>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="top-bar">
            <div class="page-title">
                <h2>Browse Library</h2>
                <p>Find your next favorite book.</p>
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
            <!-- Content will go here (e.g., Grid of books) -->
            <div
                style="background: white; padding: 2rem; border-radius: 16px; box-shadow: var(--shadow-sm); text-align: center; color: var(--text-muted);">
                <i class="ph-duotone ph-books" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <h3>Library Catalog</h3>
                <p>Books will appear here.</p>
            </div>
        </div>
    </main>

</body>

</html>