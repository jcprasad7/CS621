<?php
session_start();
include 'db.php';

// Redirect to signin.php if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

$recipes = $pdo->query('SELECT * FROM recipes')->fetchAll();

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ingredients = $_POST['ingredients'];
    $ingredientArray = explode(',', $ingredients);
    $conditions = [];
    $params = [];
    foreach ($ingredientArray as $ingredient) {
        $conditions[] = 'ingredients LIKE ?';
        $params[] = '%' . trim($ingredient) . '%';
    }
    $sql = "SELECT * FROM recipes WHERE " . implode(' OR ', $conditions);
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $recipes = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Suggestions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
            background-image: url('https://www.ppt-backgrounds.net/thumbs/food-design-keynote.jpg');
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }
        button[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        h3 {
            margin-top: 30px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        h4 {
            margin-top: 0;
        }
        p {
            margin-bottom: 5px;
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
            bottom: 0;
        }
    </style>
</head>
<header>
    <h1>Recipe Suggestions</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="recipes.php" class="active">Recipes</a>
        <a href="meal_planner.php">Meal Planner</a>
        <a href="shopping_list.php">Shopping List</a>
        <a href="add_recipe.php">Add Recipes</a>
    </nav>
</header>
<body>
    <br><br>
    <form method="POST">
        <input type="text" name="ingredients" required placeholder="Enter ingredients, separated by commas">
        <button type="submit">Find Recipes</button>
    </form>

    <?php if (!empty($recipes)): ?>
        <h3>Suggested Recipes</h3>
        <ul>
            <?php foreach ($recipes as $recipe): ?>
                <li>
                    <h4><?= htmlspecialchars($recipe['name']) ?></h4>
                    <p><strong>Ingredients:</strong> <?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
                    <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>
                    <p>Prep Time: <?= htmlspecialchars($recipe['prep_time']) ?> mins</p>
                    <p>Cook Time: <?= htmlspecialchars($recipe['cook_time']) ?> mins</p>
                    <p>Nutritional Info: <?= htmlspecialchars($recipe['nutritional_info']) ?></p>

                    <?php
                    $stmt = $pdo->prepare('SELECT c.comment, c.rating, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.recipe_id = ?');
                    $stmt->execute([$recipe['id']]);
                    $comments = $stmt->fetchAll();
                    ?>

                    <h4>Comments:</h4>
                    <?php if (!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <p><strong><?= htmlspecialchars($comment['username']) ?>:</strong> <?= htmlspecialchars($comment['comment']) ?> (Rating: <?= htmlspecialchars($comment['rating']) ?>/5)</p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No comments yet.</p>
                    <?php endif; ?>

                    <!-- Add a comment form -->
                    <form method="post" action="rate_recipe.php">
                        <input type="hidden" name="recipe_id" value="<?= $recipe['id'] ?>">
                        Rating: <input type="number" name="rating" min="1" max="5" required><br>
                        Comment: <textarea name="comment" required></textarea><br>
                        <button type="submit">Submit</button>
                    </form>
                    <br>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>No recipes found with the provided ingredients.</p>
    <?php endif; ?>
    <video class="video-bg" autoplay muted loop>
        <source src="background-video.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <footer>
        <p>&copy; 2024 Meal Planner. All rights reserved.</p>
    </footer>
</body>
</html>