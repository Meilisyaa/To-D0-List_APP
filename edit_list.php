<?php
session_start();
include 'config/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['userid']) || $_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href = '/UKK_To-Do-List/login.php';
    </script>";
    exit;
}

// Periksa apakah listid ada di URL
if (!isset($_GET['listid']) || empty($_GET['listid'])) {
    echo "<script>
    alert('ID List tidak ditemukan!');
    location.href = 'index.php';
    </script>";
    exit;
}

$listid = $_GET['listid'];
$userid = $_SESSION['userid'];

// Ambil data list dari database
$q_select = "SELECT * FROM list_tugas WHERE listid = '$listid' AND userid = '$userid'";
$run_q_select = mysqli_query($koneksi, $q_select);
$d = mysqli_fetch_assoc($run_q_select);

// Periksa apakah data ditemukan
if (!$d) {
    echo "<script>
    alert('List tidak ditemukan!');
    location.href = 'index.php';
    </script>";
    exit;
}

// Proses edit data list
if (isset($_POST['edit'])) {
    $nama_list = $_POST['nama_list'];

    $q_update = "UPDATE list_tugas SET nama_list = '$nama_list' WHERE listid = '$listid' AND userid = '$userid'";
    $run_q_update = mysqli_query($koneksi, $q_update);

    if ($run_q_update) {
        echo "<script>
        alert('List berhasil diperbarui!');
        location.href = 'index.php';
        </script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui list!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('assets/img/Background index.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .card {
            background: #FBD786;
            border-radius: 15px;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
        .btn-custom {
            border-radius: 5px;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .form-group label {
            margin-right: 10px;
            white-space: nowrap;
            font-weight: 500;
        }
        .form-group input {
            flex: 1;
        }
        .top-left-buttons {
            position: absolute;
            top: 20px;
            left: 20px;
        }
    </style>
</head>
<body>

<div class="container">
<h1 style="font-family: 'Playfair Display', cursive; color: #D1913C;">Edit List</h1>
    
    <div class="card p-4">
        <form action="" method="post">
        <div class="mb-2 text-start">
                <label for="list_tugas" class="form-label d-block text-start" style="width: 100px;">List:</label>
                <input type="text" id="tugas" name="nama_list" class="form-control"  value="<?= htmlspecialchars($d['nama_list']) ?>" required>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-custom btn-danger" onclick="history.back();">Batal</button>
                <button type="submit" name="edit" class="btn btn-custom btn-primary">Edit</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
