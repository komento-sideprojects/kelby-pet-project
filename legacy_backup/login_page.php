<?php
session_start();
include 'Database/db.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements for security
    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // In a real app, use password_verify($password, $user['password'])
        // We are using plain text for this simple project as requested by previous flow
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header('Location: Admin_Page/index.php');
            } else {
                header('Location: User_Page/index.php');
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Library MS</title>
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
                <i class="ph-bold ph-books"></i>
            </div>
            <h1>Welcome Back</h1>
            <p>Enter your credentials to access the library portal.</p>
        </header>

        <form action="" method="POST">
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
                    <button type="button" class="password-toggle" onclick="togglePassword()"
                        aria-label="Toggle password visibility">
                        <i class="ph-bold ph-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
                <a href="forgot_password.php" class="forgot-password">Forgot password?</a>
            </div>

            <?php if (isset($error)): ?>
                <div style="color: #ef4444; margin-bottom: 1rem; text-align: center; font-size: 0.9rem;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <button type="submit" name="submit" class="btn-primary">Sign In</button>
            <button type="button" class="btn-secondary" onclick="window.location.href='register.php'">Sign Up</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('ph-eye', 'ph-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('ph-eye-slash', 'ph-eye');
            }
        }
    </script>

</body>

</html>