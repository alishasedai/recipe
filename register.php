<?php include 'header.php'; ?>
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