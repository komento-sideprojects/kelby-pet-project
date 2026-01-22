<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login_page.php');
    exit();
}

$user_name = $_SESSION['user_name'] ?? 'Student';
$user_email = $_SESSION['user_email'] ?? 'student@library.com';
$user_id = $_SESSION['user_id'];

// Get initials for avatar
$initials = strtoupper(substr($user_name, 0, 2));

include '../Database/db.php';

// Fetch borrowed books for this user
$sql = "SELECT bb.*, b.title, b.author, b.category 
        FROM borrowed_books bb 
        JOIN books b ON bb.book_id = b.id 
        WHERE bb.user_id = ? AND bb.status = 'borrowed'
        ORDER BY bb.borrow_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Borrowed Books - Library MS</title>
    <link rel="stylesheet" href="../Components/admin.css?v=<?php echo time(); ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <?php $current_page = 'borrowed'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <header class="top-bar">
            <div class="page-title">
                <h2>My Borrowed Books</h2>
                <p>View and manage your borrowed books.</p>
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
            <?php if ($result->num_rows > 0): ?>
                <div style="background: white; border-radius: 16px; box-shadow: var(--shadow-sm); overflow: hidden;">
                    <table class="data-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead style="background: #f8fafc;">
                            <tr>
                                <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Book</th>
                                <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Author</th>
                                <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Category</th>
                                <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Borrowed Date</th>
                                <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Due Date</th>
                                <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()):
                                $due_date = new DateTime($row['due_date']);
                                $today = new DateTime();
                                $is_overdue = $today > $due_date;
                                $days_left = $today->diff($due_date)->days;
                                ?>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 1rem;">
                                        <div style="font-weight: 500;">
                                            <?php echo htmlspecialchars($row['title']); ?>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <?php echo htmlspecialchars($row['author']); ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <span
                                            style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; color: var(--text-muted);">
                                            <?php echo htmlspecialchars($row['category']); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; color: var(--text-muted);">
                                        <?php echo date('M d, Y', strtotime($row['borrow_date'])); ?>
                                    </td>
                                    <td style="padding: 1rem; color: var(--text-muted);">
                                        <?php echo date('M d, Y', strtotime($row['due_date'])); ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <?php if ($is_overdue): ?>
                                            <span
                                                style="color: #991b1b; background: #fee2e2; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">
                                                Overdue
                                            </span>
                                        <?php elseif ($days_left <= 3): ?>
                                            <span
                                                style="color: #ea580c; background: #ffedd5; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">
                                                Due in
                                                <?php echo $days_left; ?> day
                                                <?php echo $days_left != 1 ? 's' : ''; ?>
                                            </span>
                                        <?php else: ?>
                                            <span
                                                style="color: #166534; background: #dcfce7; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">
                                                Active
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div
                    style="background: white; padding: 3rem; border-radius: 16px; box-shadow: var(--shadow-sm); text-align: center; color: var(--text-muted);">
                    <i class="ph-duotone ph-book-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <h3>No Borrowed Books</h3>
                    <p>You haven't borrowed any books yet. Browse the library to get started!</p>
                    <a href="my_books.php" class="btn-primary" style="margin-top: 1rem; text-decoration: none;">
                        Browse Books
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>

</html>