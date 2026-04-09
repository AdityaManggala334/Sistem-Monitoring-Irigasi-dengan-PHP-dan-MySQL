<?php

session_start();
include 'koneksi.php';

if (!isset($_POST['login'])) {
    header("Location: login.php");
    exit();
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header("Location: login.php?error=kosong");
    exit();
}

$username_aman = mysqli_real_escape_string($conn, $username);

// Cari user berdasarkan username ATAU email
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username_aman' OR email='$username_aman' LIMIT 1");
$data  = mysqli_fetch_assoc($query);

if ($data) {
    if (password_verify($password, $data['password'])) {
        // Pakai nama kolom yang benar: users_id
        $_SESSION['id_users'] = $data['id_users'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['email']    = $data['email'];

        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php?error=salah");
        exit();
    }
} else {
    header("Location: login.php?error=salah");
    exit();
}
?>

