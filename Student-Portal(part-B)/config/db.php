<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "127.0.0.1";
$user = "student_user";
$pass = "vaidik@11";
$db   = "student_portal";
$port = 3307;

$conn = mysqli_connect($host, $user, $pass, $db, $port);
mysqli_set_charset($conn, "utf8mb4");