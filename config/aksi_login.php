<?php
session_start();
include 'koneksi.php';

// Tangkap data dari form
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password']; // Password asli yang diketik oleh user

// Ambil data user berdasarkan username
$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
$data = mysqli_fetch_assoc($sql);

// Jika username tidak ditemukan
if (!$data) {
    echo "<script>
    alert('Username tidak ditemukan!');
    window.location.href='../login.php';
    </script>";
    exit();
}

// Periksa apakah password cocok dengan hash yang tersimpan
if (password_verify($password, $data['password'])) {
    $_SESSION['username'] = $data['username'];
    $_SESSION['userid'] = $data['userid']; // Sesuaikan dengan nama kolom user ID
    $_SESSION['status'] = 'login';

    echo "<script>
    alert('Login berhasil!');
    window.location.href='../index.php';
    </script>";
    exit();
} else {
    echo "<script>
    alert('Password salah!');
    window.location.href='../login.php';
    </script>";
    exit();
}
?>
