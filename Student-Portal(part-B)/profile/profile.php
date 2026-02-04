<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$name  = $_SESSION['student_name'] ?? 'Student';
$id    = $_SESSION['student_id'] ?? '';
$email = $_SESSION['student_email'] ?? '';

$photo = $_SESSION['student_photo'] ?? '../assets/profile.jpg';

/*
  Optional file existence check:
  If you store photo path like "../assets/profile/abc.jpg", this will verify it.
*/
$checkPath = __DIR__ . '/../' . ltrim(str_replace(['../', './'], '', $photo), '/');
if (!file_exists($checkPath)) {
    $photo = '../assets/profile/default.png';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile</title>

  <link rel="stylesheet" href="../assets/style.css">

  <style>
    .profile-wrap {
      max-width: 900px;
      width: 100%;
      margin-top: 10px;
    }
    .profile-card {
      padding: 20px;
    }
    .profile-row {
      display: flex;
      gap: 24px;
      align-items: center;
      flex-wrap: wrap;
    }
    .profile-photo {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid rgba(255,255,255,0.35);
      box-shadow: 0 10px 25px rgba(0,0,0,0.35);
      background: rgba(255,255,255,0.06);
    }
    .profile-info p {
      margin: 10px 0;
      font-size: 16px;
      line-height: 1.4;
      opacity: 0.95;
    }
    .profile-info b {
      display: inline-block;
      min-width: 110px;
    }
  </style>
</head>
<body>

<div class="app-layout">

  <?php include "../includes/sidebar.php"; ?>

  <main class="main">
    <h1>Profile</h1>

    <div class="profile-wrap">
      <div class="card profile-card">
        <div class="profile-row">
          <img class="profile-photo" src="<?php echo htmlspecialchars($photo); ?>" alt="Profile Photo">

          <div class="profile-info">
            <p><b>Name:</b> <?php echo htmlspecialchars($name); ?></p>
            <p><b>Student ID:</b> <?php echo htmlspecialchars($id); ?></p>
            <p><b>Email:</b> <?php echo htmlspecialchars($email); ?></p>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>

</body>
</html>