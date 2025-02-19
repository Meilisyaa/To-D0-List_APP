<?php
include 'koneksi.php';

// Pastikan hanya menerima POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Akses tidak valid, hanya menerima POST request!");
}

// Pastikan tombol kirim ditekan
if (!isset($_POST['kirim'])) {
    exit("Tombol kirim tidak ditemukan!");
}

// Pastikan semua field tidak kosong
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
    exit("Semua field harus diisi!");
}

// Bersihkan data input
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = mysqli_real_escape_string($koneksi, $_POST['email']);

// Simpan ke database
$sql = "INSERT INTO user (username, password, email) VALUES ('$username', '$password', '$email')";
$query = mysqli_query($koneksi, $sql);

if ($query) {
    echo "<script>
    alert('Pendaftaran berhasil!');
    window.location.href = '../login.php';
    </script>";
    exit();
}

?>
