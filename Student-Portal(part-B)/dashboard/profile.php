<<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$name  = $_SESSION['student_name'] ?? 'Student';
$email = $_SESSION['student_email'] ?? 'Not set';
$phone = $_SESSION['student_phone'] ?? 'Not set';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
<div class="app-layout">

  <!-- Sidebar -->
  <?php include "../includes/sidebar.php"; ?>

  <!-- Main Content -->
  <main class="main">
    <h1>Profile</h1>

    <div class="grid">

      <div class="card">
        <h2>Student Information</h2>
        <p><b>Name:</b> <?php echo htmlspecialchars($name); ?></p>
        <p><b>Email:</b> <?php echo htmlspecialchars($email); ?></p>
        <p><b>Phone:</b> <?php echo htmlspecialchars($phone); ?></p>
      </div>

      <div class="card">
        <h2>About</h2>
        <p>This is your profile page. You can show your personal details here.</p>
      </div>

    </div>
  </main>

</div>
</body>
</html>