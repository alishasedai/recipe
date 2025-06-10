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


    <?php
    require_once './db/connection.php';

    // session_start();
    if (isset($_SESSION['user_id'])) {
        header("Location: /recipes/index.php");
        exit();
    }

    $successMessage = "";
    $username = $email = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if (empty($username) || empty($email) || empty($password)) {
            $successMessage = "<div class='alert error'>Please fill in all fields.</div>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $successMessage = "<div class='alert error'>Invalid email format.</div>";
        } elseif ($password !== $confirmPassword) {
            $successMessage = "<div class='alert error'>Passwords do not match.</div>";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashedPassword);

            if ($stmt->execute()) {
                $successMessage = "<div class='alert success'>Registration successful! <a href='login.php'>Login now</a>.</div>";
                $username = $email = ""; // Reset input fields
            } else {
                $successMessage = "<div class='alert error'>Error: " . $stmt->error . "</div>";
            }

            $stmt->close();
            $conn->close();
        }
    }

    ?>

    <main>
        <div class="register-container">
            <?php if (!empty($successMessage))
                echo $successMessage; ?>
            <h1>Register</h1>

            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>

                <button type="submit">Register</button>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>