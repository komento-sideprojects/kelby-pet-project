<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Not authorized
    header('Location: ../login_page.php');
    exit();
}

include '../Database/db.php';

// Fetch students
$sql = "SELECT id, name, email, created_at FROM users WHERE role = 'user' ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - Library MS</title>
    <link rel="stylesheet" href="../Components/admin.css?v=<?php echo time(); ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <?php $current_page = 'students'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <header class="top-bar">
            <div class="page-title">
                <h2>Students</h2>
                <p>Manage student accounts.</p>
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
                <i class="ph-duotone ph-users" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <h3>Student Management</h3>
                <p>View registered students and their details.</p>
                <div style="margin-top: 2rem;">
                    <?php
                    // Display success/error messages if any (not implemented yet, but good practice)
                    ?>

                    <table class="data-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 12px; color: var(--text-dark);">ID</th>
                                <th style="padding: 12px; color: var(--text-dark);">Name</th>
                                <th style="padding: 12px; color: var(--text-dark);">Email</th>
                                <th style="padding: 12px; color: var(--text-dark);">Joined Date</th>
                                <th style="padding: 12px; color: var(--text-dark);">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $joinedDate = date("M d, Y", strtotime($row['created_at']));
                                    echo "<tr style='border-bottom: 1px solid #f3f4f6;'>";
                                    echo "<td style='padding: 12px;'>#" . htmlspecialchars($row['id']) . "</td>";
                                    echo "<td style='padding: 12px; font-weight: 500;'>" . htmlspecialchars($row['name']) . "</td>";
                                    echo "<td style='padding: 12px; color: var(--text-muted);'>" . htmlspecialchars($row['email']) . "</td>";
                                    echo "<td style='padding: 12px; color: var(--text-muted);'>" . $joinedDate . "</td>";
                                    echo "<td style='padding: 12px;'>";
                                    echo "<button class='btn-danger' onclick='deleteUser(" . $row['id'] . ")'>Delete</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' style='padding: 20px; text-align: center; color: var(--text-muted);'>No students found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                function deleteUser(id) {
                    if (confirm('Are you sure you want to delete this student?')) {
                        // In a real app, this would make an AJAX call or submit a form
                        alert('Delete functionality would run here for ID: ' + id);
                    }
                }
            </script>
        </div>
    </main>

</body>

</html>