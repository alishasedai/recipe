<?php
include 'header.php';
require_once './db/connection.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p style='text-align:center;'>Invalid recipe ID.</p>";
    exit();
}

$recipe_id = intval($_GET['id']); // Sanitize input
$query = "SELECT * FROM recipes WHERE id = $recipe_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p style='text-align:center;'>Recipe not found.</p>";
    exit();
}

$recipe = mysqli_fetch_assoc($result);

// Get category from query string if exists, for back navigation
$category = isset($_GET['category']) ? $_GET['category'] : '';
$backLink = 'index.php' . ($category ? '?category=' . urlencode($category) : '');
?>

<main class="recipe-detail">
    <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
    <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>" width="200px" height="200px" class="detail-image">

    <p><strong>Category:</strong> <?php echo htmlspecialchars($recipe['category']); ?></p>
    <p><strong>Date:</strong> <?php echo date('F d, Y', strtotime($recipe['created_at'])); ?></p>

    <h3>Description</h3>
    <p><?php echo nl2br(htmlspecialchars($recipe['description'])); ?></p>

    <h3>Ingredients</h3>
    <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>

    <h3>Steps</h3>
    <p><?php echo nl2br(htmlspecialchars($recipe['steps'])); ?></p>

    <br>
    <a href="<?php echo $backLink; ?>" class="back-link">← Back to Recipes</a>
</main>

<?php include 'footer.php'; ?>