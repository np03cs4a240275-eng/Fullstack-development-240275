<?php
session_start();

// Must be logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$currentTheme = $_COOKIE['theme'] ?? 'light';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_theme'])) {
    $theme = $_POST['theme'] ?? 'light';
    if ($theme !== 'light' && $theme !== 'dark') {
        $theme = 'light';
    }

    // Save cookie for 30 days
    setcookie('theme', $theme, time() + 86400 * 30, "/");

    // Apply immediately in this request too
    $currentTheme = $theme;
    $message = "Theme updated!";
}

if ($currentTheme === 'dark') {
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
  <title>Theme Preference</title>
</head>
<body style="background: <?php echo $bg; ?>; color: <?php echo $fg; ?>; font-family: Arial, sans-serif;">
  <div style="max-width: 700px; margin: 30px auto; padding: 20px; background: <?php echo $card; ?>; border-radius: 10px;">
    <h1>Theme Preference</h1>

    <?php if ($message): ?>
      <p style="color:green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST">
      <label>Select Theme:</label>
      <select name="theme">
        <option value="light" <?php echo ($currentTheme === 'light') ? 'selected' : ''; ?>>Light</option>
        <option value="dark"  <?php echo ($currentTheme === 'dark') ? 'selected' : ''; ?>>Dark</option>
      </select>
      <button type="submit" name="save_theme">Save</button>
    </form>

    <p style="margin-top: 20px;">
      <a href="dashboard.php" style="color: <?php echo $fg; ?>;">← Back to Dashboard</a>
    </p>
  </div>
</body>
</html>
