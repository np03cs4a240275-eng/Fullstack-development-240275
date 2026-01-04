<?php
require 'db.php';
session_start();

$error = '';
$success = '';

if (isset($_GET['registered']) && $_GET['registered'] == '1') {
    $success = "Registration successful. Please login.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $student_id = trim($_POST['student_id'] ?? '');
    $password   = $_POST['password'] ?? '';

    if ($student_id === '' || $password === '') {
        $error = "Both fields are required.";
    } else {
        $sql = "SELECT student_id, full_name, password_hash FROM students WHERE student_id = ?";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$student_id]);
            $student = $stmt->fetch();

            if ($student) {
                $storedHash = $student['password_hash'];

                if (password_verify($password, $storedHash)) {
                    // Session-based state management
                    $_SESSION['logged_in'] = true;
                    $_SESSION['student_id'] = $student['student_id'];
                    $_SESSION['full_name'] = $student['full_name'];

                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error = "Invalid Student ID or Password.";
                }
            } else {
                $error = "Invalid Student ID or Password.";
            }
        } catch (PDOException $e) {
            $error = "Login failed. Try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Login</title>
</head>
<body>
  <h1>Login</h1>

  <?php if ($success): ?>
    <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
  <?php endif; ?>

  <?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <form method="POST">
    <label>Student ID:</label>
    <input type="text" name="student_id" required><br><br>

    <label>Password:</label>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Login</button>
  </form>

  <p>No account? <a href="register.php">Register</a></p>
</body>
</html>
