<?php
session_start();
if (!isset($_SESSION['student_id'])) { header("Location: ../auth/login.php"); exit; }
require_once("../includes/header.php");
include("../includes/sidebar.php");
?>
<div class="main">
  <div class="card">
    <div class="page-title">
      <h1>Web Technologies</h1>
      <p>HTML, CSS, JavaScript, PHP</p>
    </div>
  </div>
</div>
<?php require_once("../includes/footer.php"); ?>