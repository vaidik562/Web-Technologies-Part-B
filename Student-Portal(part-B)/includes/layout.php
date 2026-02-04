<?php
session_start();
$_SESSION['student_name'] = "Test Student";

include "../includes/header.php";
include "../includes/sidebar.php";
?>
<div class="main">
  <?php include "../includes/topbar.php"; ?>
  <div class="container py-4">
    <div class="card shadow">
      <div class="card-body">
        Layout working ✅
      </div>
    </div>
  </div>
</div>
<?php include "../includes/footer.php"; ?>