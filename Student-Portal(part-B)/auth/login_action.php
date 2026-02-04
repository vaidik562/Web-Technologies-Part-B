<?php
session_start();
require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, name, email, password_hash FROM students WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {

        if (password_verify($password, $row['password_hash'])) {

            $_SESSION['student_id'] = $row['id'];
            $_SESSION['student_name'] = $row['name'];
            $_SESSION['student_email'] = $row['email'];

            header("Location: ../dashboard/index.php");
            exit;

        } else {
            $_SESSION['error'] = "Invalid password";
        }

    } else {
        $_SESSION['error'] = "Email not found";
    }

    header("Location: login.php");
    exit;
}