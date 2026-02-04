<?php
session_start();
if (!isset($_SESSION['student_id'])) {
  header("Location: ../auth/login.php");
  exit;
}

$photos = ["result1.png", "result2.jpg", "result3.jpg"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Results</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="app-layout">
  <?php include "../includes/sidebar.php"; ?>

  <main class="main">
    <h1>Results Photos</h1>

    <div class="grid results-grid">
      <?php foreach ($photos as $img): ?>
        <div class="card photo-card">
          <div class="card-title"><?php echo htmlspecialchars(pathinfo($img, PATHINFO_FILENAME)); ?></div>

          <img
            src="../assets/results/<?php echo htmlspecialchars($img); ?>"
            alt="<?php echo htmlspecialchars($img); ?>"
            loading="lazy"
          />
        </div>
      <?php endforeach; ?>
    </div>

  </main>
</div>

</body>
</html>