<?php
session_start();
$error = $_SESSION['error'] ?? "";
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Login</title>
  <link rel="stylesheet" href="login.css">
</head>

<body>
  <div class="bg"></div>

  <main class="wrap">
    <div class="card">
      <div class="brand">
        <div class="logo">SP</div>
        <div>
          <h1>Student Portal</h1>
          <p>Login to continue</p>
        </div>
      </div>

      <?php if (!empty($error)) { ?>
        <div class="alert"><?= htmlspecialchars($error) ?></div>
      <?php } ?>

      <form method="POST" action="login_action.php" class="form">
        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>

        <button type="submit" class="btn">Login</button>
      </form>
    </div>
  </main>
</body>
</html>