<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Register</title>
  <link rel="stylesheet" href="login.css">
</head>

<body>
  <div class="bg"></div>

  <div class="wrap">
    <div class="card">

      <div class="brand">
        <div class="logo">SP</div>
        <div>
          <h1>Student Portal</h1>
          <p>Create your account</p>
        </div>
      </div>

      <form action="register_action.php" method="POST">

        <label for="name">Name</label>
        <input id="name" type="text" name="name" placeholder="Enter your name" required>

        <label for="email">Email</label>
        <input id="email" type="email" name="email" placeholder="Enter your email" required>

        <label for="phone">Phone Number</label>
        <input id="phone" type="text" name="phone" placeholder="Enter phone number" required>

        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="Enter password" required>

        <label for="confirm_password">Confirm Password</label>
        <input id="confirm_password" type="password" name="confirm_password" placeholder="Confirm password" required>

        <button class="btn" type="submit">Register</button>
      </form>

      <div class="footer">
        Already have an account? <a href="login.php">Login</a>
      </div>

    </div>
  </div>
</body>
</html>