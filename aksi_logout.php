<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Menampilkan alert berhasil logout
echo "<script>
    alert('Berhasil Logout!');
    window.location.href = 'login.php'; // Redirect ke halaman login
</script>";

?>
