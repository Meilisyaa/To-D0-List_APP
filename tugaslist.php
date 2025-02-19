<?php
session_start();
if (isset($_SESSION['success'])) {
    echo "<script>alert('" . $_SESSION['success'] . "');</script>";
    unset($_SESSION['success']); // Hapus session setelah ditampilkan
}

$userid = $_SESSION['userid'];
include_once 'config/koneksi.php';
if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href = '/UKK_To-Do-List/login.php';
    </script>";
}

// Proses tambah data tugas dengan deadline dan prioritas
if (isset($_POST['tambah'])) {
    $tugas = $_POST['tugas'];
    $deadline = $_POST['deadline'];
    $listid = $_POST['listid'];
    $prioritas = isset($_POST['prioritas']) ? $_POST['prioritas'] : null; // Ambil prioritas, jika tidak ada set null

    if ($tugas && $deadline && $listid && $prioritas) {
        $q_insert = "INSERT INTO tugas (tugas_label, tugas_status, userid, deadline, listid, prioritas) 
                     VALUES ('$tugas', 'open', '$userid', '$deadline', '$listid', '$prioritas')";

        $run_q_insert = mysqli_query($koneksi, $q_insert);

        if ($run_q_insert) {
            header("Location: tugaslist.php?listid=$listid");
            exit;
        } else {
            die("Gagal menambahkan tugas: " . mysqli_error($koneksi));
        }
    } else {
        echo "<script>alert('Harap isi semua bidang termasuk prioritas!');</script>";
    }
}


// Proses update status tugas
if (isset($_GET['done']) && isset($_GET['listid'])) {
    $status = ($_GET['status'] == 'open') ? 'close' : 'open';
    $listid = $_GET['listid']; 

    $q_update = "UPDATE tugas SET tugas_status = '$status' WHERE tugasid = '" . $_GET['done'] . "'";
    mysqli_query($koneksi, $q_update);
    // Redirect ke halaman 
    header("Location: tugaslist.php?listid=$listid");
    exit;
}


// Proses Menampilkan Data Tugas sesuai listid
$listid = isset($_GET['listid']) ? $_GET['listid'] : ''; 
if ($listid) {
    // Jika ada listid yang dipilih, tampilkan tugas dari list tersebut
    $q_select = "SELECT * FROM tugas WHERE userid = '$userid' AND listid = '$listid' ORDER BY tugasid DESC";
} else {
    // Jika tidak ada listid yang dipilih, tampilkan semua tugas pengguna
    $q_select = "SELECT * FROM tugas WHERE userid = '$userid' ORDER BY tugasid DESC";
}
$run_q_select = mysqli_query($koneksi, $q_select);
if (!$run_q_select) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Proses Hapus  Tugas dalam List
if (isset($_GET['delete'])) {
    $tugasid = $_GET['delete']; // Ambil tugasid yang ingin dihapus

    // Ambil listid berdasarkan tugas yang dihapus sebelum dihapus
    $q_get_listid = "SELECT listid FROM tugas WHERE tugasid = '$tugasid'";
    $result = mysqli_query($koneksi, $q_get_listid);
    $row = mysqli_fetch_assoc($result);
    $listid = $row['listid'] ?? ''; // Pastikan listid ada sebelum digunakan

    // Hapus tugas setelah mendapatkan listid
    $q_delete = "DELETE FROM tugas WHERE tugasid = '$tugasid'";
    mysqli_query($koneksi, $q_delete);

    // Redirect ke halaman dengan listid yang benar
    header("Location: tugaslist.php?listid=$listid");
    exit();
}
// Ambil nama list berdasarkan listid
$q_get_listname = "SELECT nama_list FROM list_tugas WHERE listid = '$listid'";
$result_listname = mysqli_query($koneksi, $q_get_listname);
$row_listname = mysqli_fetch_assoc($result_listname);
$nama_list = $row_listname['nama_list'] ?? 'Daftar Tugas';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<h1 style="font-family: 'Georgia', cursive; color: #D1913C;">
    <?= htmlspecialchars($nama_list) ?>
</h1>
    <div class="d-flex justify-content-between">
</div>
    <div class="top-right-buttons">
        <a href="javascript:void(0);" class="btn btn-danger btn-custom" onclick="confirmLogout()">Logout</a>
    </div>
    <div class="top-left-buttons">
    <a href="index.php" class="btn btn-secondary btn-custom">⬅ Kembali</a>
    </div>

    <div class="card p-3 mt-3">
        <form action="" method="post">
             <!-- Hidden Input untuk listid -->
            <input type="hidden" name="listid" value="<?= isset($_GET['listid']) ? $_GET['listid'] : ''; ?>">
            <div class="mb-2 text-start">
                <label for="tugas" class="form-label d-block text-start" style="width: 100px;">Tugas:</label>
                <input type="text" id="tugas" name="tugas" class="form-control" placeholder="Judul Tugas" required >
            </div>
            <div class="mb-2 text-start">
                <label for="prioritas" class="form-label d-block text-start" style="width: 100px;">Prioritas:</label>
                <select id="prioritas" name="prioritas" class="form-control" required>
                    <option value="" disabled selected>Pilih Tingkatan Prioritas</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div class="mb-2 text-start">
                <label for="deadline" class="form-label d-block text-start" style="width: 100px;">Deadline:</label>
                <input type="date" id="deadline" name="deadline" class="form-control" required >
            </div>
            <button type="submit" name="tambah" class="btn btn-success btn-custom">Tambah Tugas</button>
        </form>
    </div>
    <br>
    
    <?php while ($r = mysqli_fetch_array($run_q_select)) {
        $deadline = date('d-m-Y', strtotime($r['deadline']));
        $today = date('Y-m-d');
        $isLate = ($r['deadline'] < $today) ? true : false;
    ?>
        <div class="card p-3 mt-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                <input type="checkbox" 
                    onclick="window.location.href='?done=<?= $r['tugasid'] ?>&status=<?= $r['tugas_status'] ?>&listid=<?= $_GET['listid'] ?>'"
                    <?= ($r['tugas_status'] == 'close') ? 'checked' : '' ?>>
                    <span class="<?= ($r['tugas_status'] == 'close') ? 'text-decoration-line-through text-primary' : '' ?>">
                    <?= $r['tugas_label'] ?>
                    </span>
                </div>
                <div>
                    <a href="edit.php?id=<?= $r['tugasid'] ?>" class="text-warning">✏️</a>
                    <a href="?delete=<?= $r['tugasid'] ?>" class="text-danger" onclick="return confirm('Hapus tugas?')">🗑️</a>
                </div>
            </div>
            <div class="text-muted">
                Deadline: <?= $deadline ?> |
                Prioritas: <span class="
                    <?= ($r['prioritas'] == 'low') ? 'text-success' : (($r['prioritas'] == 'medium') ? 'text-warning' : 'text-danger') ?>">
                    <?= ucfirst($r['prioritas']) ?>
                </span>
            </div>


            <?php if ($isLate && $r['tugas_status'] == 'open') { ?>
                <div class="alert alert-danger mt-2">⚠️ Tugas ini melewati deadline!</div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<br>
</body>
</html>
