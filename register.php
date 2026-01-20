<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    include 'Database/db.php';

    if (isset($_POST['submit'])) {
        $name = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Use prepared statements for security
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            header('Location: login_page.php');
            exit();
        } else {
            if ($stmt->errno === 1062) {
                // Duplicate entry error
                echo "<script>alert('This email is already registered. Please log in or use a different email.');</script>";
            } else {
                throw new Exception("Execute failed: " . $stmt->error);
            }
        }
        $stmt->close();
    }
} catch (Exception $e) {
    echo "<div style='color: red; padding: 20px; text-align: center; font-weight: bold;'>Error: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Library MS</title>
    <link rel="stylesheet" href="Components/style.css?v=2">
    <!-- Icon library (using Phosphor Icons for a modern look) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <!-- Decorative Background Shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="login-container">
        <header class="login-header">
            <div class="logo-icon">
                <i class="ph-bold ph-user-plus"></i>
            </div>
            <h1>Create Account</h1>
            <p>Join our library community today.</p>
        </header>

        <form action="" method="POST">
            <div class="form-group">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" id="fullname" name="fullname" class="form-input" placeholder="John Doe" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="library@example.com"
                    required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••"
                        required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)"
                        aria-label="Toggle password visibility">
                        <i class="ph-bold ph-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" name="submit" class="btn-primary">Sign Up</button>

            <button type="button" class="btn-secondary" onclick="window.location.href='login_page.php'">
                Already have an account? Log In
            </button>
        </form>
    </div>

    <script>
        function togglePassword(inputId, toggleBtn) {
            const input = document.getElementById(inputId);
            const toggleBtnIcon = toggleBtn.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                toggleBtnIcon.classList.replace('ph-eye', 'ph-eye-slash');
            } else {
                input.type = 'password';
                toggleBtnIcon.classList.replace('ph-eye-slash', 'ph-eye');
            }
        }
    </script>

</body>

</html>