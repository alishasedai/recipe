<?php
include 'header.php';
require_once './db/connection.php';
?>

<?php



if (!isset($_SESSION['user_id'])) {
    header("Location: /recipes/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and collect form inputs
    $user_id     = $_SESSION['user_id'];
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $steps       = mysqli_real_escape_string($conn, $_POST['steps']);
    $category    = mysqli_real_escape_string($conn, $_POST['category']);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir  = 'uploads/';
        // Create uploads directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $originalName = basename($_FILES['image']['name']);
        $timestamp    = time();
        $targetPath   = $uploadDir . $timestamp . '_' . $originalName;
        $tmpPath      = $_FILES['image']['tmp_name'];

        if (move_uploaded_file($tmpPath, $targetPath)) {
            // Insert into database
            $sql = "
                INSERT INTO recipes 
                    (user_id, title, description, ingredients, steps, category, image, created_at)
                VALUES 
                    ($user_id, '$title', '$description', '$ingredients', '$steps', '$category', '$targetPath', NOW())
            ";

            if (mysqli_query($conn, $sql)) {
                echo "
                    <script>
                        alert('Recipe added successfully!');
                        window.location.href = 'index.php';
                    </script>
                ";
                exit();
            } else {
                $dbError = mysqli_error($conn);
                echo "
                    <script>
                        alert('Database error: $dbError');
                        window.history.back();
                    </script>
                ";
                exit();
            }
        } else {
            echo "
                <script>
                    alert('Failed to upload image.');
                    window.history.back();
                </script>
            ";
            exit();
        }
    } else {
        echo "
            <script>
                alert('Please select an image to upload.');
                window.history.back();
            </script>
        ";
        exit();
    }
}

?>



<main>


    <h2>Add New Recipe</h2>

    <form action="/recipes/add_recipe.php" method="post" enctype="multipart/form-data">
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
</main>

<?php
include 'footer.php';
?>