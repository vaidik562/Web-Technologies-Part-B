<?php
session_start();

if (!isset($_SESSION['student_id'])) {
  header("Location: ../auth/login.php");
  exit;
}

$studentName = $_SESSION['student_name'] ?? 'Student';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="app-layout">

  <!-- Sidebar -->
  <aside class="sidebar">
    <h2 class="logo">Student Portal</h2>

    <nav class="menu">
      <a href="index.php" class="active">Dashboard</a>
      <a href="../subjects.php">Subjects</a>
      <a href="../results.php">Results</a>
      <a href="../profile.php">Profile</a>
      <a href="../degrees.php">Degrees</a>
      <a href="../projects.php">Projects</a>
      <a href="../auth/logout.php" class="logout">Logout</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="main">
    <h1>Dashboard</h1>

    <div class="card">
      <h3>Welcome</h3>
      <p>
        <?php echo htmlspecialchars($_SESSION['student_name']); ?>
      </p>
      <p>This is your student dashboard.</p>
    </div>
  </main>

</div>

</body>
</html>