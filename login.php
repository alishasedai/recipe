<?php include 'header.php';


?>


<?php
require_once './db/connection.php';
$errorMessage = "";


if (isset($_SESSION['user_id'])) {
    header("Location: /recipes/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $errorMessage = "<div class='alert error'>Please fill in all fields.</div>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                header("Location: /recipes/index.php");
                exit();
            } else {
                $errorMessage = "<div class='alert error'>Invalid username or password.</div>";
            }
        } else {
            $errorMessage = "<div class='alert error'>Invalid username or password.</div>";
        }

        $stmt->close();
    }
}

?>

<main>
    <div class="login-container">
        <?php if (!empty($errorMessage))
            echo $errorMessage; ?>
        <h1>Login</h1>

        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>