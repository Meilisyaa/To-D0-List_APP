<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #A1FFCE;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #FAFFD1, #A1FFCE);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #FAFFD1, #A1FFCE); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .navbar {
            background: #A1FFCE;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #FAFFD1, #A1FFCE);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #FAFFD1, #A1FFCE); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar-brand, .nav-link {
            color: #D1913C !important;
            font-weight: bold;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .custom-icon i {
            font-size: 50px;
        }

        .card-custom {
            background-color: beige;
            border: 2px solid #d3cfcf;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin-top: 80px;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
        }

        .form-label {
            font-weight: bold;
        }
        .nav-link {
            color: #D1913C; 
            font-weight: bold; 
            text-decoration: none; 
        }

        .nav-link:hover {
            color: #FAF6E3; 
            text-decoration: underline; 
        }
        .navbar-brand {
            color: #D1913C !important;
            font-weight: bold; 
            text-decoration: none;
        }
        .custom-icon i {
        font-size: 50px;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
    <a class="navbar-brand custom-icon" style="margin-left: -80px; margin-right: 20px;">
    <i class="fas fa-clipboard-list"></i>
    </a>


    <a class="navbar-brand" href="index.php" style="margin-left: -5px; color: #D1913C !important;">
   To Do List
    </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
        <div class="navbar-nav me-auto">
        </div>
        <a href="register.php" class="btn btn-primary m-1">Daftar</a>
        <a href="login.php" class="btn btn-success m-1">Masuk</a>
        </div>
    </div>
    </nav>

<br>
<br>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
                <div class="card-body" style="background-color: beige; border: 2px solid #d3cfcf; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 400px; margin: auto;">
                    <div class="text-center">
                    <h5 style="font-weight: bold; color: #D1913C;">
                    <span style="font-size: 24px; margin-right: 8px;">🔒</span>Daftar Akun Baru
                    </h5>
                    <br>
                </div>
                <form action="config/aksi_register.php" method="POST">
                    <label class="form-label" style="margin-top: 10px;">Username</label>
                    <input type="text" name="username" class="form-control" required style="background-color: #f5f5dc; border: 1px solid #ddd;">

                    <label class="form-label" style="margin-top: 10px;">Password</label>
                    <input type="password" name="password" class="form-control" required style="background-color: #f5f5dc; border: 1px solid #ddd;">

                    <label class="form-label" style="margin-top: 10px;">Email</label>
                    <input type="email" name="email" class="form-control" required style="background-color: #f5f5dc; border: 1px solid #ddd;">

                <div class="d-grid mt-3">
                <button class="btn btn-primary" type="submit" name="kirim" value="daftar">DAFTAR</button>
                </div>
                </form>
            <hr style="border-top: 1px solid #d3cfcf;">
            <p class="text-center">Sudah punya akun? <a href="login.php" style="color: #D1913C; font-weight: bold;">Masuk disini</a></p>
            </div>
        </div>
    </div>
</div>



<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
