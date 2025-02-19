<?php
session_start();
include_once 'config/koneksi.php';

//menampilkan alert belum login
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    $_SESSION['error_message'] = "Anda belum Login!";
    header('Location: /UKK_To-Do-List/login.php');
    exit;
}

$userid = $_SESSION['userid'];


// Proses tambah data list 
if (isset($_POST['tambah'])) {
    $nama_list = $_POST['nama_list'];
    $q_insert = "INSERT INTO list_tugas (nama_list, userid) VALUES ('$nama_list', '$userid')";
    $run_q_insert = mysqli_query($koneksi, $q_insert);

    if ($run_q_insert) {
        header('Refresh:0; url=index.php');
    }
}
            
// Ambil data tugas dari database
$q_select = "SELECT * FROM list_tugas WHERE userid = '$userid' ORDER BY listid DESC";
$run_q_select = mysqli_query($koneksi, $q_select);

if (!$run_q_select) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Proses Hapus List Tugas
if (isset($_GET['delete'])) {
    $listid = $_GET['delete'];

    // Hapus semua tugas terkait dalam list ini
    $q_delete_tugas = "DELETE FROM tugas WHERE listid = '$listid'";
    mysqli_query($koneksi, $q_delete_tugas);

    // Hapus list_tugas berdasarkan listid
    $q_delete_list = "DELETE FROM list_tugas WHERE listid = '$listid'";
    
    if (mysqli_query($koneksi, $q_delete_list)) {
        header("Location: index.php"); // Redirect ke halaman utama setelah berhasil
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <title>To Do List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
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
        }
        .btn-custom {
            border-radius: 5px;
        }
        .form-group {
            display: flex;
            align-items: center;
        }
        .form-group label {
            margin-right: 10px;
            white-space: nowrap;
            text-align: left;
        }
        .form-group input {
            flex: 1;
        }
        .top-right-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .top-right-buttons a {
            margin-left: 10px;
        }
        .top-left-buttons {
        position: absolute;
        top: 20px;
        left: 20px;
        }

    </style>
    <script>
        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin keluar?")) {
                window.location.href = "aksi_logout.php";
            }
        }
    </script>
</head>
<body>
<div class="container text-center">
<h1 style="font-family: 'Lobster', cursive; color: #D1913C;">
    <span style="display: inline-block; transform: scale(1.5);">📝</span> To Do List
</h1>
<br>
<p style="color: #D1913C;"> <?= date("l, d M Y") ?> </p>
    <div class="top-right-buttons">
        <a href="detail.php" class="btn btn-primary btn-custom">Lihat Detail</a>
        <a href="javascript:void(0);" class="btn btn-danger btn-custom" onclick="confirmLogout()">Logout</a>
    </div>
    <div class="card p-3 mt-3">
        <form action="" method="post">
            <div class="mb-2 text-start">
                <label for="nama_list" class="form-label d-block text-start" style="width: 100px;">List:</label>
                <input type="text" id="nama_list" name="nama_list" class="form-control" placeholder="Nama List" required >
            </div>
            <button type="submit" name="tambah" class="btn btn-success btn-custom">Tambah List</button>
        </form>
    </div>
    <br>
    
    <?php while ($r = mysqli_fetch_array($run_q_select)) { ?>
    <div class="card p-3 mt-2">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span><?= $r['nama_list'] ?></span>
            </div>
            <div>
    <a href="tugaslist.php?listid=<?= $r['listid'] ?>" class="text-primary">📄</a>
    <a href="edit_list.php?listid=<?= $r['listid'] ?>" class="text-warning">✏️</a> 
    <a href="?delete=<?= $r['listid'] ?>" class="text-danger" onclick="return confirm('Hapus daftar List ini?')">🗑️</a>
</div>

        </div>
    </div>
<?php } ?>

</div>
</body>
</html>
