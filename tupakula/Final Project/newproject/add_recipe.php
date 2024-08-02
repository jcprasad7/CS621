<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $prep_time = $_POST['prep_time'];
    $cook_time = $_POST['cook_time'];
    $nutritional_info = $_POST['nutritional_info'];

    $stmt = $pdo->prepare('INSERT INTO recipes (name, ingredients, instructions, prep_time, cook_time, nutritional_info) VALUES (?, ?, ?, ?, ?, ?)');
    if ($stmt->execute([$name, $ingredients, $instructions, $prep_time, $cook_time, $nutritional_info])) {
        echo "Recipe added successfully.";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #ff69b4;
            padding-top: 60px;
            color: #fff;
            background-image: url('add_receipeui.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            color: #000;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #000;
        }
        .form-control {
            border-radius: 4px;
            margin-bottom: 15px;
        }
        textarea {
            resize: vertical;
        }
        button[type="submit"] {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }
        button[type="submit"]:hover {
            background-color: #c82333;
        }
        .navbar-nav .nav-link {
            color: white;
        }
        .navbar {
            background-color: #333;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand" href="#">Recipe App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="recipes.php">Find Recipes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="meal_planner.php">Meal Planner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shopping_list.php">Shopping List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Add Recipe</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Recipe Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredients</label>
                <textarea class="form-control" id="ingredients" name="ingredients" required></textarea>
            </div>
            <div class="mb-3">
                <label for="instructions" class="form-label">Instructions</label>
                <textarea class="form-control" id="instructions" name="instructions" required></textarea>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="prep_time" class="form-label">Prep Time (minutes)</label>
                    <input type="number" class="form-control" id="prep_time" name="prep_time" required>
                </div>
                <div class="col">
                    <label for="cook_time" class="form-label">Cook Time (minutes)</label>
                    <input type="number" class="form-control" id="cook_time" name="cook_time" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="nutritional_info" class="form-label">Nutritional Info</label>
                <textarea class="form-control" id="nutritional_info" name="nutritional_info" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Recipe</button>
        </form>
    </div>
<br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
