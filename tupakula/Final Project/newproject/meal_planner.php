<?php
session_start();
include 'db.php';

// Redirect to signin.php if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch recipes from the database
$stmt = $pdo->prepare("SELECT id, name FROM recipes");
$stmt->execute();
$recipes = $stmt->fetchAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipe_id = $_POST['recipe_id'];
    $date = $_POST['date'];

    $stmt = $pdo->prepare('INSERT INTO meal_plans (user_id, recipe_id, date) VALUES (?, ?, ?)');
    if ($stmt->execute([$_SESSION['user_id'], $recipe_id, $date])) {
        echo "Meal planned successfully.";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

$recipes = $pdo->query('SELECT * FROM recipes')->fetchAll();
$meal_plans = $pdo->prepare('SELECT * FROM meal_plans WHERE user_id = ?');
$meal_plans->execute([$_SESSION['user_id']]);
$plans = $meal_plans->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meal Planning Calendar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 20px;
            background-image: url('meal_planner_background.jpg');
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
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

        .shopping-list-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .shopping-list-container h2 {
            margin-top: 0;
        }

        .add-item-form {
            margin-bottom: 20px;
        }

        .add-item-form input {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            width: calc(100% - 120px);
            margin-right: 10px;
        }

        .add-item-form button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100px;
        }

        .add-item-form button:hover {
            background-color: #0056b3;
        }

        .shopping-list {
            list-style-type: none;
            padding: 0;
        }

        .shopping-list li {
            background: #fff;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .shopping-list button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .shopping-list button:hover {
            background-color: #c82333;
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
    </style>
</head>
<header>
        <h1>Meal Planner</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="recipes.php">Recipes</a>
            <a href="meal_planner.php">Meal Planner</a>
            <a href="shopping_list.php" class="active">Shopping List</a>
            <a href="add_recipe.php" class="btn">Add Recipe</a>
        </nav>
    </header>
<body>
<div class="container">
        <div class="form-container">
            <form method="post" action="">
                <div class="form-group">
                    <label for="recipe_id" class="form-label">Select Recipe:</label>
                    <select name="recipe_id" id="recipe_id" class="form-select" required>
                        <?php foreach ($recipes as $recipe) { ?>
                            <option value="<?php echo $recipe['id']; ?>"><?php echo htmlspecialchars($recipe['name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date" class="form-label">Select Date:</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add to Meal Plan</button>
            </form>
        </div>

        <div class="form-container">
            <h3 style="color: yellow;">Your Meal Plan</h3>
            <ul>
                <?php foreach ($plans as $plan) { ?>
                    <li><?php echo htmlspecialchars($plan['date']); ?>: <?php echo htmlspecialchars($recipes[array_search($plan['recipe_id'], array_column($recipes, 'id'))]['name']); ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2024 Meal Planner. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
