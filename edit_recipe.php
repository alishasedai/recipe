<?php
include 'header.php';
require_once './db/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /recipes/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Recipe ID is missing.";
    exit();
}

$id = intval($_GET['id']); // sanitize input

// Fetch existing recipe data
$query = "SELECT * FROM recipes WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Recipe not found.";
    exit();
}

$recipe = mysqli_fetch_assoc($result);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $steps = mysqli_real_escape_string($conn, $_POST['steps']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Optional: handle image upload if you want to allow changing image
    // For now, let's keep existing image

    $updateQuery = "UPDATE recipes SET
                    title = '$title',
                    description = '$description',
                    ingredients = '$ingredients',
                    steps = '$steps',
                    category = '$category'
                    WHERE id = $id";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Recipe updated successfully!'); window.location.href='index.php';</script>";
        exit();
    } else {
        echo "Error updating recipe: " . mysqli_error($conn);
    }
}
?>

<main>
    <h2>Edit Recipe</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="3" required><?php echo htmlspecialchars($recipe['description']); ?></textarea><br><br>

        <label>Ingredients:</label><br>
        <textarea name="ingredients" rows="4" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea><br><br>

        <label>Steps:</label><br>
        <textarea name="steps" rows="5" required><?php echo htmlspecialchars($recipe['steps']); ?></textarea><br><br>

        <label>Category:</label><br>
        <select name="category" required>
            <option value="Breakfast" <?php if ($recipe['category'] == 'Breakfast') echo 'selected'; ?>>Breakfast</option>
            <option value="Lunch" <?php if ($recipe['category'] == 'Lunch') echo 'selected'; ?>>Lunch</option>
            <option value="Dinner" <?php if ($recipe['category'] == 'Dinner') echo 'selected'; ?>>Dinner</option>
            <option value="Dessert" <?php if ($recipe['category'] == 'Dessert') echo 'selected'; ?>>Dessert</option>
            <option value="Snacks" <?php if ($recipe['category'] == 'Snacks') echo 'selected'; ?>>Snacks</option>
        </select><br><br>

        <!-- Optional: show current image -->
        <label>Current Image:</label><br>
        <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="Current Image" style="max-width: 200px;"><br><br>

        <!-- Optional: allow to upload new image -->
        <!-- <label>Change Image:</label><br>
        <input type="file" name="image" accept="image/*"><br><br> -->

        <input type="submit" value="Update Recipe">
    </form>
</main>

<?php include 'footer.php'; ?>