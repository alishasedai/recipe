<?php
include 'header.php';  // if needed
require_once './db/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /recipes/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Optional: Get recipe image path to delete file from server
    $select = "SELECT image FROM recipes WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = $row['image'];

        // Delete the recipe from database
        $delete = "DELETE FROM recipes WHERE id = $id";
        if (mysqli_query($conn, $delete)) {
            // Delete image file from server if exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Redirect with success message
            header("Location: index.php?msg=Recipe deleted successfully");
            exit();
        } else {
            echo "Error deleting recipe: " . mysqli_error($conn);
        }
    } else {
        echo "Recipe not found.";
    }
} else {
    echo "Invalid request.";
}
