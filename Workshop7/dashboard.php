<?php
session_start();

// Check authentication
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Logout action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$username = $_SESSION['full_name'] ?? 'Student';

// Theme cookie
$theme = $_COOKIE['theme'] ?? 'light'; // default = light mode

// Basic CSS based on theme
if ($theme === 'dark') {
    $bg = '#111';
    $fg = '#f5f5f5';
    $card = '#1d1d1d';
} else {
    $bg = '#ffffff';
    $fg = '#111111';
    $card = '#f3f3f3';
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
</head>
<body style="background: <?php echo $bg; ?>; color: <?php echo $fg; ?>; font-family: Arial, sans-serif;">
  <div style="max-width: 700px; margin: 30px auto; padding: 20px; background: <?php echo $card; ?>; border-radius: 10px;">
    <h1>Welcome <?php echo htmlspecialchars($username); ?> 👋</h1>
    <p><b>Theme:</b> <?php echo htmlspecialchars($theme); ?></p>

    <hr>

    <h3>Navigation</h3>
    <ul>
      <li><a href="preference.php" style="color: <?php echo $fg; ?>;">Change Theme Preference</a></li>
      <!-- Add more portal pages here if you have them -->
    </ul>

    <form method="POST" style="margin-top: 20px;">
      <button type="submit" name="logout">Logout</button>
    </form>
  </div>
</body>
</html>
