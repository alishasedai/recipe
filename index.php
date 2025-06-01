<?php
include 'header.php';
require_once './db/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /recipes/login.php");
    exit();
}
?>

<main>
    <h1 style="text-align: center;">Our Recipes</h1>

    <section class="recipes-section">
        <div class="recipe-grid">

            <!-- Static Recipe Card 1 -->
            <!-- <div class="recipe-card">
                <img src="./assets/images/reciepe1.jpg" alt="Recipe 1 Image" class="recipe-image" />
                <div class="recipe-content">
                    <h2 class="recipe-title">Classic Pancakes</h2>
                    <p class="recipe-category"><strong>Category:</strong> Breakfast</p>
                    <p class="recipe-date"><strong>Created At:</strong> 2025-06-01</p>
                    <p class="recipe-description">
                        Fluffy, golden pancakes perfect for a weekend breakfast.
                    </p>
                    <a href="recipe.php?id=1" class="see-more-btn">See More</a>
                </div>
            </div>

            <!-- Static Recipe Card 2
            <div class="recipe-card">
                <img src="./assets/images/recipe2.jpg" alt="Recipe 2 Image" class="recipe-image" />
                <div class="recipe-content">
                    <h2 class="recipe-title">Spaghetti Bolognese</h2>
                    <p class="recipe-category"><strong>Category:</strong> Italian</p>
                    <p class="recipe-date"><strong>Created At:</strong> 2025-05-28</p>
                    <p class="recipe-description">
                        Rich and hearty meat sauce served with spaghetti noodles.
                    </p>
                     <a href="recipe.php?id=2" class="see-more-btn">See More</a> 
                    <a href="recipe_detail.php?id=
                //<?php echo $row['id']; ?>" class="see-more-btn">See More</a>

                </div>
            </div> -->

            <!-- Dynamic Recipes From Database -->
            <?php
            $query = "SELECT * FROM recipes ORDER BY created_at DESC";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="recipe-card">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="recipe-image" />

                        <div class="recipe-content">
                            <h2 class="recipe-title"><?php echo htmlspecialchars($row['title']); ?></h2>
                            <p class="recipe-category"><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
                            <p class="recipe-date"><strong>Created At:</strong> <?php echo date('Y-m-d', strtotime($row['created_at'])); ?></p>
                            <p class="recipe-description"><?php echo substr(htmlspecialchars($row['description']), 0, 100) . '...'; ?></p>
                            <a href="recipe_detail.php?id=<?php echo $row['id']; ?>" class="see-more-btn">See More</a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No recipes found.</p>";
            }
            ?>
        </div>
    </section>
</main>


<?php require_once 'footer.php'; ?>