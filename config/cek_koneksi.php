<?php
include 'koneksi.php';

if ($koneksi) {
    echo "Koneksi ke database berhasil!";
} else {
    echo "Koneksi gagal!";
}
?>
