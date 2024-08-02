<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $age = $_POST['age'];
    $activity_level = $_POST['activity_level'];

    // Simple BMR calculation (Mifflin-St Jeor Equation)
    $bmr = 10 * $weight + 6.25 * $height - 5 * $age + 5; // for men
    // $bmr = 10 * $weight + 6.25 * $height - 5 * $age - 161; // for women

    // Adjust BMR based on activity level
    switch ($activity_level) {
        case 'sedentary':
            $daily_calories = $bmr * 1.2;
            break;
        case 'light':
            $daily_calories = $bmr * 1.375;
            break;
        case 'moderate':
            $daily_calories = $bmr * 1.55;
            break;
        case 'active':
            $daily_calories = $bmr * 1.725;
            break;
        case 'very_active':
            $daily_calories = $bmr * 1.9;
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrition Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
        }

        header nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }

        header nav a.active {
            font-weight: bold;
        }

        main {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .calculator-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .calculator-container h2 {
            margin-top: 0;
        }

        .calculator-form {
            display: flex;
            flex-direction: column;
        }

        .calculator-form input,
        .calculator-form select,
        .calculator-form button {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .calculator-form select {
            width: 100%;
        }

        .calculator-form button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .calculator-form button:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .result {
            background-color: #e9f7ef;
            border: 1px solid #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Meal Planner</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="recipes.php">Recipes</a>
            <a href="meal_planner.php">Meal Planner</a>
            <a href="shopping_list.php">Shopping List</a>
            <a href="profile.php">Profile</a>
        </nav>
    </header>

    <main>
        <div class="calculator-container">
            <h2>Nutrition Calculator</h2>
            <form method="POST" class="calculator-form">
                <input type="number" name="weight" required placeholder="Weight (kg)">
                <input type="number" name="height" required placeholder="Height (cm)">
                <input type="number" name="age" required placeholder="Age">
                <select name="activity_level" required>
                    <option value="sedentary">Sedentary</option>
                    <option value="light">Lightly active</option>
                    <option value="moderate">Moderately active</option>
                    <option value="active">Active</option>
                    <option value="very_active">Very active</option>
                </select>
                <button type="submit">Calculate</button>
            </form>

            <?php if (isset($daily_calories)): ?>
                <div class="result">
                    <h3>Your Daily Calorie Intake:</h3>
                    <p><?= round($daily_calories) ?> kcal/day</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Meal Planner. All rights reserved.</p>
    </footer>
</body>
</html>
