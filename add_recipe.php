<?php
include 'header.php';
require_once './db/connection.php'; 
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Recipe</title>
</head>

<body>

    <h2>Add New Recipe</h2>

    <form action="insert.php" method="post" enctype="multipart/form-data">
        <label>User ID:</label><br>
        <input type="number" name="user_id" required><br><br>

        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="3" required></textarea><br><br>

        <label>Ingredients:</label><br>
        <textarea name="ingredients" rows="4" required></textarea><br><br>

        <label>Steps:</label><br>
        <textarea name="steps" rows="5" required></textarea><br><br>

        <label>Category:</label><br>
        <select name="category" required>
            <option value="">--Select--</option>
            <option value="Breakfast">Breakfast</option>
            <option value="Lunch">Lunch</option>
            <option value="Dinner">Dinner</option>
            <option value="Dessert">Dessert</option>
            <option value="Snacks">Snacks</option>
        </select><br><br>

        <label>Image:</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>

        <input type="submit" value="Add Recipe">
    </form>

</body>

</html>