<?php
if (!isset($current_page)) {
    $current_page = 'dashboard';
}

$adminName = $_SESSION['user_name'] ?? 'Admin User';
$adminEmail = $_SESSION['user_email'] ?? 'admin@library.com';

// Get initials (first letter of first name + first letter of last name, or just first 2 letters)
$parts = explode(' ', $adminName);
$initials = '';
if (count($parts) >= 2) {
    $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
} else {
    $initials = strtoupper(substr($adminName, 0, 2));
}
?>
<!-- Sidebar -->
<aside class="sidebar">
    <div class="logo-section">
        <i class="ph-bold ph-books logo-icon"></i>
        <span class="logo-text">LMS Admin</span>
    </div>

    <ul class="nav-links">
        <li class="nav-item">
            <a href="index.php" class="<?php echo ($current_page === 'dashboard') ? 'active' : ''; ?>">
                <i class="ph-duotone ph-squares-four"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="books.php" class="<?php echo ($current_page === 'books') ? 'active' : ''; ?>">
                <i class="ph-duotone ph-books"></i>
                <span>Books</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="students.php" class="<?php echo ($current_page === 'students') ? 'active' : ''; ?>">
                <i class="ph-duotone ph-users"></i>
                <span>Students</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="issued_books.php" class="<?php echo ($current_page === 'issued_books') ? 'active' : ''; ?>">
                <i class="ph-duotone ph-arrow-fat-lines-up"></i>
                <span>Issued Books</span>
            </a>
        </li>
        <li class="nav-item" style="margin-top: auto;">
            <a href="settings.php" class="<?php echo ($current_page === 'settings') ? 'active' : ''; ?>">
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
        <div class="avatar">
            <?php echo $initials; ?>
        </div>
        <div class="user-info">
            <h4>
                <?php echo htmlspecialchars($adminName); ?>
            </h4>
            <p>
                <?php echo htmlspecialchars($adminEmail); ?>
            </p>
        </div>
    </div>
</aside>