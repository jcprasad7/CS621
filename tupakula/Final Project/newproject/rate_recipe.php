<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $recipe_id = $_POST['recipe_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $pdo->prepare('INSERT INTO comments (user_id, recipe_id, rating, comment) VALUES (?, ?, ?, ?)');
    if ($stmt->execute([$user_id, $recipe_id, $rating, $comment])) {
        echo "Comment added successfully.";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

header('Location: recipes.php');
exit();
?>
