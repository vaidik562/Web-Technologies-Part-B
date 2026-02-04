<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subjects</title>

    <!-- CSS path correct -->
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="app-layout">

    <!-- Sidebar -->
    <?php include "../includes/sidebar.php"; ?>

    <!-- Main content -->
    <main class="main">
        <h1>Subjects</h1>

        <div class="grid">
            <div class="card">
                <h3>Web Development</h3>
                <p>HTML, CSS, JavaScript, PHP</p>
            </div>

            <div class="card">
                <h3>Software Development</h3>
                <p>C, C++, Java</p>
            </div>
        </div>
    </main>

</div>

</body>
</html>