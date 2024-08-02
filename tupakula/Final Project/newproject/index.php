<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Suggestion and Meal Planning App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Pacifico', cursive;
            background-image: url('');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: rgba(245, 245, 245, 0.5);
        }
        h1,h2{
            color: white;
            font-family: 'Pacifico', cursive;
        }
        p{
            color: white;
            font-family: 'Pacifico', cursive;
        }
        header {
            font-family: 'Pacifico', cursive;
            background-color: #343a40;
            color: #ffffff;
            padding: 1rem 0;
            text-align: center;
            font-family: 'Roboto', sans-serif;
        }
        main {
            padding: 2rem;
        }
        .navbar-custom {
            background-color: #343a40;
            border-bottom: 3px solid #dc3545;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-nav .nav-link {
            color: #ffffff;
        }
        .navbar-custom .nav-link:hover {
            color: #dc3545;
        }
        .navbar-custom .btn-outline-success {
            color: #ffffff;
            border-color: #ffffff;
        }
        .navbar-custom .btn-outline-success:hover {
            color: #343a40;
            background-color: #ffffff;
        }
        .navbar-custom .form-control {
            width: 300px;
        }
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-primary:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }
        .btn-success {
            background-color: #198754;
            border-color: #198754;
        }
        .btn-success:hover {
            background-color: #155724;
            border-color: #155724;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: -15px;
        }
        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body>
    <video class="video-bg" autoplay muted loop>
        <source src="background-video.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form class="d-flex">
                        <span class="navbar-text me-3">Hello, User!</span>
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                <?php else: ?>
                    <div>
                        <a href="signup.php" class="btn btn-primary">Sign Up</a>
                        <a href="signin.php" class="btn btn-primary">Sign In</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
<br> <br> <br> <br> <br>
    <main class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 align="center">Welcome to Your Recipe Suggestion and Meal Planning App!</h2><br>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <p align="center">Here you can find recipes, plan your meals, create shopping lists, rate recipes, add your own recipes, and calculate nutrition information.</p>
                <?php else: ?>
                    <p align="center">Please sign up or sign in to start using all the features of our app.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Meal Planner. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
