<?php
include 'header.php';
require_once './db/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /recipes/login.php");
    exit();
}
?>

<main>
    <h1>Our Recipes</h1>

    <section class="recipes-section">
        <div class="recipe-grid">

            <!-- Recipe Card 1 -->
            <div class="recipe-card">
                <img src="./assets/images/reciepe1.jpg" alt="Recipe 1 Image" class="recipe-image" />

                <div class="recipe-content">
                    <h2 class="recipe-title">Classic Pancakes</h2>
                    <p class="recipe-category"><strong>Category:</strong> Breakfast</p>
                    <p class="recipe-date"><strong>Created At:</strong> 2025-06-01</p>
                    <p class="recipe-description">
                        Fluffy, golden pancakes perfect for a weekend breakfast.
                    </p>

                    <!-- The 'See More' button links to a detail page with full recipe -->
                    <a href="recipe.php?id=1" class="see-more-btn">See More</a>
                </div>
            </div>

            <!-- Recipe Card 2 -->
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
                </div>
            </div>

            <!-- Add more recipe cards similarly -->

        </div>
    </section>
</main>

<?php require_once 'footer.php'; ?>