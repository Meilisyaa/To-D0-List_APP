<?php
session_start();
$userid = $_SESSION['userid'];
require_once 'config/koneksi.php';

if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href = '/UKK_To-Do-List/login.php';
    </script>";
}

$q_open = "SELECT * FROM tugas WHERE userid = '$userid' AND tugas_status = 'open' ORDER BY tugasid DESC";
$q_close = "SELECT * FROM tugas WHERE userid = '$userid' AND tugas_status = 'close' ORDER BY tugasid DESC";

$run_q_open = mysqli_query($koneksi, $q_open);
$run_q_close = mysqli_query($koneksi, $q_close);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail To-Do List</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background-image: url('assets/img/Background index.png');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            width: 600px;
            height: 100vh;
            margin: 0 auto;
            padding-top: 50px;
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #D1913C;
            margin-bottom: 20px;
        }
        .header i {
            font-size: 40px;
            margin-right: 10px;
        }
        .card {
            border: none;
            background-color: #FBD786;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
            margin-bottom: 15px;
        }
        .tugas-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 16px;
            font-weight: 500;
        }
        .tugas-item.done span {
            color: black;
            text-decoration: line-through;
        }
        .top-left-buttons {
            position: absolute;
            top: 20px;
            left: 20px;
        }
        
    </style>
</head>
<body>

<div class="top-left-buttons">
    <a href="index.php" class="btn btn-secondary btn-custom">⬅ Kembali</a>
    </div>
    
<div class="container">
    <div class="header">
        <i class="fas fa-tasks"></i>
        <span>Detail Tugas</span>
    </div>
    <div class="content">
    <div class="card">
        <h4 class="section-header bg-primary text-white p-2 rounded">Belum Selesai</h4>
        <div class="card-body">
            <?php if (mysqli_num_rows($run_q_open) > 0) {
                while ($task = mysqli_fetch_array($run_q_open)) { ?>
                    <div class="tugas-item border-bottom py-2">
                        <span><?= $task['tugas_label'] ?></span>
                        <span class="<?= ($task['prioritas'] == 'low') ? 'text-success' : (($task['prioritas'] == 'medium') ? 'text-warning' : 'text-danger') ?>">
                            <?= ucfirst($task['prioritas']) ?>
                        </span>
                    </div>
            <?php } } else { ?>
                <p class="text-muted">Belum ada tugas</p>
            <?php } ?>
        </div>
    </div>

    <div class="card">
        <h4 class="section-header bg-success text-white p-2 rounded">Selesai</h4>
        <div class="card-body">
            <?php if (mysqli_num_rows($run_q_close) > 0) {
                while ($task = mysqli_fetch_array($run_q_close)) { ?>
                    <div class="tugas-item done border-bottom py-2">
                        <span><?= $task['tugas_label'] ?></span>
                        <small class="text-muted"><?= date('d-m-Y', strtotime($task['tanggal'])) ?></small>
                    </div>
            <?php } } else { ?>
                <p class="text-muted">Belum ada tugas selesai</p>
            <?php } ?>
        </div>
    </div>
</div>

    

</body>
</html>
