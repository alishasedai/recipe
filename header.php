<?php
session_start(); // Start session to check login
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Recipe Sharing Site</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>
    <header>
        <div class="navbar">
            <a href="/index.php" class="logo">MyRecipes</a>
            <nav>
                <a href="/index.php">Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/add_recipe.php">Add Recipe</a>
                    <a href="/user.php">Profile</a>
                    <a href="/logout.php">Logout</a>
                <?php else: ?>
                    <a href="/login.php">Login</a>
                    <a href="/register.php">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main>