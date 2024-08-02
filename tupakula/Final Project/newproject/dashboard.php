<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #f5f5f5; /* Light background color */
            background-image: url('https://wallpapers.com/images/featured/black-gold-background-optua4rlhb9gnk6t.jpg');
        }
        header {
            background-color: #343a40;
            color: #ffffff;
            padding: 1rem 0;
            text-align: center;
        }
        main {
            padding: 2rem;
            text-align: center;
        }
        .card {
            max-width: 500px;
            margin: 0 auto;
            padding: 2rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card h2 {
            margin-bottom: 1.5rem;
            color: #343a40;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #dc3545;
            color: #ffffff;
            border: 1px solid #dc3545;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .btn:hover {
            background-color: #c82333;
            border-color: #c82333;
            color: #ffffff;
        }
        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
    </header>
    <main>
        <div class="card">
            <h2>Welcome to Your Dashboard!</h2>
            <p>Explore the features of the app:</p>
            <ul class="list-unstyled">
                <li><a href="index.php" class="btn">Home</a></li>
                <li><a href="recipes.php" class="btn">Find Recipes</a></li>
                <li><a href="meal_planner.php" class="btn">Meal Planner</a></li>
                <li><a href="shopping_list.php" class="btn">Shopping List</a></li>
                <li><a href="add_recipe.php" class="btn">Add Recipe</a></li>
                <li><a href="nutrition_calculator.php" class="btn">Nutrition Calculator</a></li>
                <li><a href="update_preferences.php" class="btn">Update Preferences</a></li>
                <li><a href="logout.php" class="btn btn-secondary">Logout</a></li>
            </ul>
        </div>
    </main>
</body>
</html>
