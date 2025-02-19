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

$q_open = "SELECT * FROM tugas WHERE userid = '$userid' AND tugas_status = 'open'";
$q_close = "SELECT * FROM tugas WHERE userid = '$userid' AND tugas_status = 'close'";

$run_q_open = mysqli_query($koneksi, $q_open);
$run_q_close = mysqli_query($koneksi, $q_close);

$count_open = mysqli_num_rows($run_q_open);
$count_close = mysqli_num_rows($run_q_close);
$total_tasks = $count_open + $count_close;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
         * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('assets/img/Background index.png');
            background-size: cover;
            background-repeat: no-repeat;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
            padding-top: 50px;
            max-width: 1200px;
            margin: auto;
        }
        .content-wrapper {
            display: flex;
            justify-content: center;
            gap: 30px;
            width: 100%;
        }
        .card {
            border: none;
            background-color: #FBD786;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
            margin-bottom: 15px;
            width: 450px;
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
        .chart-container {
            width: 450px;
            height: 450px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        canvas {
            width: 100% !important;
            height: auto !important;
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
    <div class="content-wrapper">
        <div>
            <div class="card">
                <h4 class="bg-warning text-white p-2 rounded">Belum Selesai</h4>
                <div class="card-body">
                    <?php if ($count_open > 0) {
                        while ($task = mysqli_fetch_array($run_q_open)) { ?>
                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span><?= $task['tugas_label'] ?></span>
                                <small class="text-muted"><?= date('d-m-Y', strtotime($task['tanggal'])) ?></small>
                            </div>
                    <?php } } else { ?>
                        <p class="text-muted">Belum ada tugas</p>
                    <?php } ?>
                </div>
            </div>
            <div class="card">
                <h4 class="bg-success text-white p-2 rounded">Selesai</h4>
                <div class="card-body">
                    <?php if ($count_close > 0) {
                        while ($task = mysqli_fetch_array($run_q_close)) { ?>
                            <div class="border-bottom py-2 d-flex justify-content-between">
                                <span><?= $task['tugas_label'] ?></span>
                                <small class="text-muted"><?= date('d-m-Y', strtotime($task['tanggal'])) ?></small>
                            </div>
                    <?php } } else { ?>
                        <p class="text-muted">Belum ada tugas selesai</p>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="chart-container">
            <h5 class="text-center">Progress Tugas</h5>
            <canvas id="taskChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('taskChart').getContext('2d');
        var taskChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Belum Selesai', 'Selesai'],
                datasets: [{
                    data: [<?= $count_open ?>, <?= $count_close ?>],
                    backgroundColor: ['#f39c12', '#28a745'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    });
</script>
</body>
</html>
