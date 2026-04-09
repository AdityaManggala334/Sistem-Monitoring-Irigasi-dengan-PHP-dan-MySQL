<?php
include 'koneksi.php';

if (!isset($_POST['register'])) {
    header("Location: login.php");
    exit();
}

$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email']    ?? '');
$password = $_POST['password'] ?? '';
$konfirm  = $_POST['konfirm']  ?? '';

// Validasi input
if (empty($username) || empty($email) || empty($password) || empty($konfirm)) {
    header("Location: login.php?tab=register&reg_error=kosong");
    exit();
}

if (strlen($password) < 6) {
    header("Location: login.php?tab=register&reg_error=pendek");
    exit();
}

if ($password !== $konfirm) {
    header("Location: login.php?tab=register&reg_error=beda");
    exit();
}

$username_aman = mysqli_real_escape_string($conn, $username);
$email_aman    = mysqli_real_escape_string($conn, $email);

// Cek duplikat username/email
$cek = mysqli_query($conn, "SELECT id_users FROM users WHERE username='$username_aman' OR email='$email_aman' LIMIT 1");
if (mysqli_num_rows($cek) > 0) {
    header("Location: login.php?tab=register&reg_error=duplikat");
    exit();
}

// Simpan ke database
$hash  = password_hash($password, PASSWORD_DEFAULT);
$query = "INSERT INTO users (username, email, password) VALUES ('$username_aman', '$email_aman', '$hash')";

if (mysqli_query($conn, $query)) {
    header("Location: login.php?sukses=register");
    exit();
} else {
    header("Location: login.php?tab=register&reg_error=gagal");
    exit();
}
?>
