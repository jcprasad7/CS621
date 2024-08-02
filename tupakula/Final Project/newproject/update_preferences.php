<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dietary_preferences = $_POST['dietary_preferences'];
    $allergies = $_POST['allergies'];

    $stmt = $pdo->prepare('REPLACE INTO preferences (user_id, dietary_preferences, allergies) VALUES (?, ?, ?)');
    if ($stmt->execute([$_SESSION['user_id'], $dietary_preferences, $allergies])) {
        echo "Preferences updated successfully.";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

$preferences = $pdo->prepare('SELECT * FROM preferences WHERE user_id = ?');
$preferences->execute([$_SESSION['user_id']]);
$prefs = $preferences->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Preferences</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            background-image: url('https://www.ppt-backgrounds.net/thumbs/food-design-keynote.jpg');
            background-size: cover;
            background-attachment: fixed;
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
            margin: 20px auto;
        }

        .preferences-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .preferences-container h2 {
            margin-top: 0;
            font-size: 24px;
        }

        .preferences-form {
            display: flex;
            flex-direction: column;
        }

        .preferences-form label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .preferences-form input {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .preferences-form button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .preferences-form button:hover {
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
            <a href="add_recipe.php" class="btn">Add Recipe</a>
        </nav>
    </header>

    <main>
        <div class="preferences-container">
            <h2>Update Preferences</h2>
            <form method="post" action="" class="preferences-form">
                <label for="dietary_preferences">Dietary Preferences:</label>
                <input type="text" id="dietary_preferences" name="dietary_preferences" placeholder="Enter Dietary Preferences" value="<?php echo htmlspecialchars($prefs['dietary_preferences']); ?>" required>
                
                <label for="allergies">Allergies:</label>
                <input type="text" id="allergies" name="allergies" placeholder="Allergies" value="<?php echo htmlspecialchars($prefs['allergies']); ?>" required>
                
                <button type="submit">Update Preferences</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Meal Planner. All rights reserved.</p>
    </footer>
</body>
</html>
