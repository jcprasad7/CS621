<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item = $_POST['item'];
    $category = $_POST['category'];

    $stmt = $pdo->prepare('INSERT INTO shopping_list (user_id, item, category) VALUES (?, ?, ?)');
    if ($stmt->execute([$_SESSION['user_id'], $item, $category])) {
        echo "Item added to shopping list.";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM shopping_list WHERE id = ? AND user_id = ?');
    if ($stmt->execute([$_GET['delete'], $_SESSION['user_id']])) {
        echo "Item removed from shopping list.";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

$shopping_list = $pdo->prepare('SELECT * FROM shopping_list WHERE user_id = ?');
$shopping_list->execute([$_SESSION['user_id']]);
$list = $shopping_list->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            background-image: url('shoppinglist_background.jpg');
            background-size: cover;
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
            display: flex;
            flex-direction: column;
        }

        .add-item-form label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .add-item-form input, .add-item-form select {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .add-item-form button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
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

        .shopping-list a {
            text-decoration: none;
            color: #dc3545;
            font-weight: bold;
        }

        .shopping-list a:hover {
            color: #c82333;
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
<body>
    <header>
        <h1>Shopping List</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="recipes.php">Recipes</a>
            <a href="meal_planner.php">Meal Planner</a>
            <a href="shopping_list.php" class="active">Shopping List</a>
            <a href="add_recipe.php" class="btn">Add Recipe</a>
        </nav>
    </header>

    <main>
        <div class="shopping-list-container">
            <form method="post" action="" class="add-item-form">
                <label for="item">Item:</label>
                <input type="text" name="item" id="item" required>
                <label for="category">Category:</label>
                <select name="category" id="category">
                    <option value="Produce">Veggies</option>
                    <option value="Dairy">Dairy</option>
                    <option value="Meat">Meat</option>
                    <option value="Other">Other</option>
                </select>
                <button type="submit">Add to Shopping List</button>
            </form>

            <h2>Your Shopping List</h2>
            <?php if (!empty($list)): ?>
                <ul class="shopping-list">
                    <?php foreach ($list as $item): ?>
                        <li>
                            <?php echo htmlspecialchars($item['item']); ?> (<?php echo htmlspecialchars($item['category']); ?>)
                            <a href="?delete=<?php echo $item['id']; ?>">Remove</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <form method="get" action="download_shopping_list.php">
                    <button type="submit">Download Shopping List</button>
                </form>
            <?php else: ?>
                <p>No items in your shopping list.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
