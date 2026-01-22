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

// Handle Borrow Book
if (isset($_POST['borrow_book'])) {
    $book_id = (int) $_POST['book_id'];

    // Check if book is available
    $checkBook = $conn->prepare("SELECT available FROM books WHERE id = ?");
    $checkBook->bind_param("i", $book_id);
    $checkBook->execute();
    $result = $checkBook->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();

        if ($book['available'] > 0) {
            // Calculate dates
            $borrow_date = date('Y-m-d');
            $due_date = date('Y-m-d', strtotime('+14 days'));

            // Insert into borrowed_books
            $stmt = $conn->prepare("INSERT INTO borrowed_books (user_id, book_id, borrow_date, due_date, status) VALUES (?, ?, ?, ?, 'borrowed')");
            $stmt->bind_param("iiss", $user_id, $book_id, $borrow_date, $due_date);

            if ($stmt->execute()) {
                // Decrement available count
                $updateBook = $conn->prepare("UPDATE books SET available = available - 1 WHERE id = ?");
                $updateBook->bind_param("i", $book_id);
                $updateBook->execute();
                $updateBook->close();

                header('Location: my_books.php?success=borrowed');
                exit();
            } else {
                $error = "Error borrowing book: " . $conn->error;
            }
            $stmt->close();
        } else {
            $error = "This book is currently unavailable.";
        }
    }
    $checkBook->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Books - Library MS</title>
    <link rel="stylesheet" href="../Components/admin.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <?php $current_page = 'my_books'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <header class="top-bar">
            <div class="page-title">
                <h2>Browse Books</h2>
                <p>Discover available books in the library.</p>
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

            <?php if (isset($_GET['success']) && $_GET['success'] == 'borrowed'): ?>
                <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    Book borrowed successfully! Check "My Borrowed Books" to view it.
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php
            $sql = "SELECT * FROM books ORDER BY created_at DESC";
            $result = $conn->query($sql);
            ?>

            <?php if ($result->num_rows > 0): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div
                            style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; height: 100%;">
                            <div style="flex: 1;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                    <span
                                        style="background: #f1f5f9; color: var(--text-muted); font-size: 0.75rem; padding: 4px 8px; border-radius: 4px; font-weight: 500;">
                                        <?php echo htmlspecialchars($row['category']); ?>
                                    </span>
                                    <?php if ($row['available'] > 0): ?>
                                        <span style="color: #166534; font-size: 0.75rem; font-weight: 600;">Available</span>
                                    <?php else: ?>
                                        <span style="color: #991b1b; font-size: 0.75rem; font-weight: 600;">Out of Stock</span>
                                    <?php endif; ?>
                                </div>
                                <h3
                                    style="font-size: 1.25rem; font-weight: 700; color: var(--text-color); margin-bottom: 0.25rem;">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </h3>
                                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">
                                    by <?php echo htmlspecialchars($row['author']); ?>
                                </p>
                            </div>
                            <div style="margin-top: auto;">
                                <form method="POST" action="" style="margin: 0;">
                                    <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="borrow_book" class="btn-primary"
                                        style="width: 100%; justify-content: center;" <?php echo ($row['available'] == 0) ? 'disabled style="background: #cbd5e1; cursor: not-allowed;"' : ''; ?>>
                                        <?php echo ($row['available'] > 0) ? 'Borrow Book' : 'Unavailable'; ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div
                    style="background: white; padding: 3rem; border-radius: 16px; box-shadow: var(--shadow-sm); text-align: center; color: var(--text-muted);">
                    <i class="ph-duotone ph-books" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <h3>Library is Empty</h3>
                    <p>No books have been added yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>

</html>