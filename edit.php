<?php 
ini_set('session.use_only_cookies', 1);
ini_set('session.use_trans_sid', 0);
include 'database.php';

session_start(); // Pastikan session hanya dipanggil sekali

// Ambil data tugas berdasarkan ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: ID tugas tidak ditemukan.");
}

$q_select = "SELECT * FROM tugas WHERE tugasid = '" . $_GET['id'] . "'";
$run_q_select = mysqli_query($conn, $q_select);
$d = mysqli_fetch_object($run_q_select);

if (!$d) {
    die("Error: Data tugas tidak ditemukan.");
}

// Proses edit data
if (isset($_POST['edit'])) {
    $tugas = $_POST['tugas'];
    $deadline = $_POST['deadline'];
    $prioritas = $_POST['prioritas'];

    $q_update = "UPDATE tugas SET tugas_label = '$tugas', deadline = '$deadline', prioritas = '$prioritas' WHERE tugasid = '" . $_GET['id'] . "'";
    $run_q_update = mysqli_query($conn, $q_update);

    if (!$run_q_update) {
        die("Error: Gagal mengupdate tugas. " . mysqli_error($conn));
    }

    
    

    // Ambil listid dari tugas berdasarkan tugasid
    $q_get_listid = "SELECT listid FROM tugas WHERE tugasid = '" . $_GET['id'] . "'";
    $run_q_get_listid = mysqli_query($conn, $q_get_listid);

    if (!$run_q_get_listid) {
        die("Query gagal: " . mysqli_error($conn));
    }

    $data_list = mysqli_fetch_assoc($run_q_get_listid);
    
    if (!$data_list) {
        die("Error: listid tidak ditemukan.");
    }

    $listid = $data_list['listid'];

    // Set flag sukses dalam session
    $_SESSION['success'] = "Tugas berhasil diperbarui!";

    // Redirect ke halaman  tugas_list
    header("Location: tugaslist.php?listid=$listid");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
            text-align: left;
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

<?php
// Tampilkan alert jika ada session success
if (isset($_SESSION['success'])) {
    echo "<script>alert('" . $_SESSION['success'] . "');</script>";
    unset($_SESSION['success']); // Hapus session setelah ditampilkan
}
?>

<div class="container">
    <h1 style="font-family: 'Playfair Display', cursive; color: #D1913C;">Edit Tugas</h1>
    <div class="card p-4">
        <form action="" method="post">
            <div class="mb-2 text-start">
                <label for="tugas" class="form-label d-block text-start" style="width: 100px;">Tugas:</label>
                <input type="text" id="tugas" name="tugas" class="form-control" placeholder="Judul Tugas" value="<?= $d->tugas_label ?>" required>
            </div>
            <div class="mb-2 text-start">
                <label for="deadline" class="form-label d-block text-start" style="width: 100px;">Deadline:</label>
                <input type="date" id="deadline" name="deadline" class="form-control" value="<?= $d->deadline ?>" required>
            </div>
            <div class="mb-2 text-start">
                <label for="prioritas" class="form-label d-block text-start" style="width: 100px;">Prioritas:</label>
                <select id="prioritas" name="prioritas" class="form-control">
                    <option value="" disabled>Pilih Tingkatan Prioritas</option>
                    <option value="low" <?= ($d->prioritas == 'low') ? 'selected' : '' ?>>Low</option>
                    <option value="medium" <?= ($d->prioritas == 'medium') ? 'selected' : '' ?>>Medium</option>
                    <option value="high" <?= ($d->prioritas == 'high') ? 'selected' : '' ?>>High</option>
                </select>
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
