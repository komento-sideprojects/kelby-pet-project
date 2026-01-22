<!-- Sidebar -->
<aside class="sidebar">
    <div class="logo-section">
        <i class="ph-bold ph-books logo-icon"></i>
        <span class="logo-text">LMS Student</span>
    </div>

    <ul class="nav-links">
        <li class="nav-item">
            <a href="index.php" class="<?php echo ($current_page == 'home') ? 'active' : ''; ?>">
                <i class="ph-duotone ph-house"></i>
                <span>Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="my_books.php" class="<?php echo ($current_page == 'my_books') ? 'active' : ''; ?>">
                <i class="ph-duotone ph-books"></i>
                <span>Browse Books</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="borrowed.php" class="<?php echo ($current_page == 'borrowed') ? 'active' : ''; ?>">
                <i class="ph-duotone ph-book-open"></i>
                <span>My Borrowed Books</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="history.php" class="<?php echo ($current_page == 'history') ? 'active' : ''; ?>">
                <i class="ph-duotone ph-clock-counter-clockwise"></i>
                <span>History</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="favorites.php" class="<?php echo ($current_page == 'favorites') ? 'active' : ''; ?>">
                <i class="ph-duotone ph-heart"></i>
                <span>Favorites</span>
            </a>
        </li>
        <li class="nav-item" style="margin-top: auto;">
            <a href="settings.php" class="<?php echo ($current_page == 'settings') ? 'active' : ''; ?>">
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