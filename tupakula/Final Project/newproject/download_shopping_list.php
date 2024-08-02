<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

$shopping_list = $pdo->prepare('SELECT * FROM shopping_list WHERE user_id = ?');
$shopping_list->execute([$_SESSION['user_id']]);
$list = $shopping_list->fetchAll();

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="shopping_list.txt"');

foreach ($list as $item) {
    echo $item['item'] . " (" . $item['category'] . ")\n";
}
exit();
?>
