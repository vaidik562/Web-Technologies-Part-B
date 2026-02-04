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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates</title>

    <link rel="stylesheet" href="../assets/style.css">

    <style>
        .cert-grid{
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
            gap:20px;
            margin-top:20px;
        }
        .cert-card{
            background:#111;
            padding:12px;
            border-radius:12px;
            text-align:center;
        }
        .cert-card img{
            width:100%;
            height:auto;
            border-radius:8px;
            object-fit:contain;
        }
    </style>
</head>
<body>

<div class="app-layout">

    <?php include "../includes/sidebar.php"; ?>

    <main class="main">
        <h1>Certificates</h1>

        <div class="cert-grid">

            <div class="cert-card">
                <img src="images/cert1.jpg" alt="Certificate 1">
            </div>

            <div class="cert-card">
                <img src="images/cert2.jpg" alt="Certificate 2">
            </div>

            <div class="cert-card">
                <img src="images/cert3.jpg" alt="Certificate 3">
            </div>

        </div>
    </main>

</div>

</body>
</html>