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
    <section class="recipes-section">
        <h1 style="text-align: center; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color: #4caf50">Our Recipes</h1>
        <div class="recipe-grid">
            <?php
            $query = "SELECT * FROM recipes ORDER BY created_at DESC";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="recipe-card">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="recipe-image" />
                        <div class="recipe-content">
                            <div class="recipe_time">
                                <p class="recipe-category"><span class="badgee"> <?php echo htmlspecialchars($row['category']); ?> </span></p>
                                <p class="recipe-date">

                                    <?php
                                    $timestamp = strtotime($row['created_at']);
                                    $day = date('j', $timestamp);
                                    $daySuffix = date('S', $timestamp); // st, nd, rd, th
                                    echo date('F', $timestamp) . " {$day}{$daySuffix}, " . date('Y', $timestamp);
                                    ?>
                                </p>

                            </div>
                            <h2 class="recipe-title"><?php echo htmlspecialchars($row['title']); ?></h2>
                            <!-- <p class="recipe-category"><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p> -->
                            <p class="recipe-description"><?php echo substr(htmlspecialchars($row['description']), 0, 100) . '...'; ?></p>
                            <a href="recipe_detail.php?id=<?php echo $row['id']; ?>" class="see-more-btn">See More</a>
                            <div class="edit_delete_recipe">
                                <a href="edit_recipe.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="delete_recipe.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this recipe?');" class="delete-btn">Delete</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p style='text-align: center;'>No recipes found.</p>";
            }
            ?>
        </div>
    </section>
</main>

<?php require_once 'footer.php'; ?>