<?php
session_start(); // Start session to check login
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Recipe Sharing Site</title>
    <link rel="stylesheet" href="./assets/style.css" />
    <link rel="stylesheet" href="./assets/login.css" />
    <link rel="stylesheet" href="./assets/register.css">
    <link rel="stylesheet" href="./assets/add_recipe.css">
    <!-- <link rel="stylesheet" href="./assets/recipe.css"> -->
    <link rel="stylesheet" href="./assets/edit.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">

</head>

<body>
    <header>
        <div class="navbar">
            <a href="/recipes/index.php" class="logo">MyRecipes</a>
            <img src="/recipes/assets/images/logo.jpg" alt="Recipe Logo" class="logo-img" width="200px" height="50px" style="object-fit: cover;">
            <nav>
                <a href="/recipes/index.php">Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/recipes/add_recipe.php">Add_Recipe</a>
                    <!-- <a href="/recipes/user.php">Profile</a> -->
                    <a href="/recipes/logout.php">Logout</a>
                <?php else: ?>
                    <a href="/recipes/login.php">Login</a>
                    <a href="/recipes/register.php">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    