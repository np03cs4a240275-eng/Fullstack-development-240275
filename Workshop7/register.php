<?php
require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $student_id = trim($_POST['student_id'] ?? '');
    $name       = trim($_POST['name'] ?? '');
    $password   = $_POST['password'] ?? '';

    if ($student_id === '' || $name === '' || $password === '') {
        $error = "All fields are required.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert with prepared statement
        $sql = "INSERT INTO students (student_id, full_name, password_hash) VALUES (?, ?, ?)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$student_id, $name, $hashedPassword]);

            // Redirect to login after success
            header("Location: login.php?registered=1");
            exit;
        } catch (PDOException $e) {
            // Common: duplicate student_id (if student_id is PRIMARY KEY / UNIQUE)
            if ($e->getCode() === '23000') {
                $error = "That Student ID is already registered.";
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
</head>
<body>
  <h1>Student Registration</h1>

  <?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <form method="POST">
    <label>Student ID:</label>
    <input type="text" name="student_id" required><br><br>

    <label>Name:</label>
    <input type="text" name="name" required><br><br>

    <label>Password:</label>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="add_student">Register</button>
  </form>

  <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
