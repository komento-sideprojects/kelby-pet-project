<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Not authorized
    header('Location: ../login_page.php');
    exit();
}

include '../Database/db.php';

// Handle Add Book
if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $quantity = (int) $_POST['quantity'];

    // Simple validation
    if (!empty($title) && !empty($author)) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, category, quantity, available) VALUES (?, ?, ?, ?, ?)");
        // Available starts same as quantity
        $stmt->bind_param("sssii", $title, $author, $category, $quantity, $quantity);

        if ($stmt->execute()) {
            // Redirect to prevent form resubmission
            header('Location: books.php?success=1');
            exit();
        } else {
            $error = "Error adding book: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Title and Author are required.";
    }
}

// Handle Delete Book
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM books WHERE id=$id");
    header('Location: books.php'); // Redirect to clear query param
    exit();
}

// Fetch Books
$sql = "SELECT * FROM books ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books - Library MS</title>
    <link rel="stylesheet" href="../Components/admin.css?v=<?php echo time(); ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <?php $current_page = 'books'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <header class="top-bar">
            <div class="page-title">
                <h2>Books</h2>
                <p>Manage library inventory.</p>
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

            <?php if (isset($_GET['success'])): ?>
                <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    Book added successfully!
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div style="display: flex; justify-content: flex-end; margin-bottom: 1rem;">
                <button class="btn-primary" onclick="openModal()">
                    <i class="ph-bold ph-plus"></i> Add New Book
                </button>
            </div>

            <div style="background: white; border-radius: 16px; box-shadow: var(--shadow-sm); overflow: hidden;">
                <table class="data-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Title</th>
                            <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Author</th>
                            <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Tag</th>
                            <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Qty</th>
                            <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Status</th>
                            <th style="padding: 1rem; font-weight: 600; color: var(--text-color);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
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
                                    <td style="padding: 1rem;">
                                        <?php echo $row['quantity']; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <?php if ($row['available'] > 0): ?>
                                            <span
                                                style="color: #166534; background: #dcfce7; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">Available</span>
                                        <?php else: ?>
                                            <span
                                                style="color: #991b1b; background: #fee2e2; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">Out
                                                of Stock</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            <button class="action-btn" style="width: 32px; height: 32px;" title="Edit">
                                                <i class="ph-bold ph-pencil-simple"></i>
                                            </button>
                                            <a href="?delete=<?php echo $row['id']; ?>" class="action-btn"
                                                style="width: 32px; height: 32px; color: #ef4444; border-color: #fee2e2; background: #fef2f2;"
                                                title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="ph-bold ph-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                                    <i class="ph-duotone ph-books"
                                        style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                    <p>No books found. Add one to get started!</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Add Book Modal -->
    <div id="addBookModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <div class="form-header">
                <h3>Add New Book</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Fill in the details below to add a new book to
                    the library.</p>
            </div>

            <form action="" method="POST">
                <div class="form-group">
                    <label class="form-label">Book Title</label>
                    <input type="text" name="title" class="form-input" placeholder="e.g. The Great Gatsby" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Author</label>
                    <input type="text" name="author" class="form-input" placeholder="e.g. F. Scott Fitzgerald" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-input" value="1" min="1" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Category / Genre</label>
                    <select name="category" class="form-input">
                        <option value="Fiction">Fiction</option>
                        <option value="Non-Fiction">Non-Fiction</option>
                        <option value="Science">Science</option>
                        <option value="History">History</option>
                        <option value="Technology">Technology</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Art">Art</option>
                        <option value="Music">Music</option>
                        <option value="Sports">Sports</option>
                        <option value="Health">Health</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
                    <button type="button" class="btn-danger"
                        style="background-color: transparent; color: var(--text-muted); border: 1px solid var(--border-color);"
                        onclick="closeModal()">Cancel</button>
                    <button type="submit" name="add_book" class="btn-primary">Add Book</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addBookModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('addBookModal').classList.remove('show');
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            var modal = document.getElementById('addBookModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

</body>

</html>