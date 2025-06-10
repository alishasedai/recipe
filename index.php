<?php
include 'header.php';
require_once './db/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /recipes/login.php");
    exit();
}
?>
<?php if (isset($_GET['msg'])): ?>
    <div class="alert success">
        <?php echo htmlspecialchars($_GET['msg']); ?>
    </div>
<?php endif; ?>


<main>

    <form method="GET" style="text-align: center; margin-bottom: 20px;">
        <label for="category">Search by Category:</label>
        <select name="category" id="category" style="padding: 6px; margin-left: 8px;">
            <option value="">-- Select Category --</option>
            <option value="Breakfast" <?php if (isset($_GET['category']) && $_GET['category'] === 'Breakfast') echo 'selected'; ?>>Breakfast</option>
            <option value="Lunch" <?php if (isset($_GET['category']) && $_GET['category'] === 'Lunch') echo 'selected'; ?>>Lunch</option>
            <option value="Dinner" <?php if (isset($_GET['category']) && $_GET['category'] === 'Dinner') echo 'selected'; ?>>Dinner</option>
            <option value="Dessert" <?php if (isset($_GET['category']) && $_GET['category'] === 'Dessert') echo 'selected'; ?>>Dessert</option>
            <option value="Snacks" <?php if (isset($_GET['category']) && $_GET['category'] === 'Snacks') echo 'selected'; ?>>Snacks</option>
        </select>
        <button type="submit" style="padding: 6px 12px; margin-left: 10px; cursor: pointer;">Search</button>
    </form>

    <section class="recipes-section">

        <div class="recipe-grid">

            <?php
            $category = $_GET['category'] ?? '';

            if (!empty($category)) {
                // Use prepared statement for safety
                $stmt = $conn->prepare("SELECT * FROM recipes WHERE category = ? ORDER BY created_at DESC");
                $stmt->bind_param("s", $category);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>

                        <div class="recipe-card">
                            <h1 style="text-align: center; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color: #4caf50">Our Recipes</h1>
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="recipe-image" />

                            <div class="recipe-content">
                                <h2 class="recipe-title"><?php echo htmlspecialchars($row['title']); ?></h2>
                                <p class="recipe-category"><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
                                <p class="recipe-date"><strong>Created At:</strong> <?php echo date('Y-m-d', strtotime($row['created_at'])); ?></p>
                                <p class="recipe-description"><?php echo substr(htmlspecialchars($row['description']), 0, 100) . '...'; ?></p>
                                <a href="recipe_detail.php?id=<?php echo $row['id']; ?>&category=<?php echo urlencode($category ?? ''); ?>" class="see-more-btn">See More</a>

                                <div class="edit_delete_recipe">
                                    <a href="edit_recipe.php?id=<?php echo $row['id']; ?>">Edit</a>
                                    <a href="delete_recipe.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this recipe?');" class="delete-btn">Delete</a>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo "<p style='text-align: center;'>No recipes found in this category.</p>";
                }
            } else {
                // Show message if no category selected yet
                echo "<p style='text-align: center;'>Please select a category to see recipes.</p>";
            }
            ?>

        </div>
    </section>
</main>

<?php require_once 'footer.php'; ?>