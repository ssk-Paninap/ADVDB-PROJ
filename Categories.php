<?php
session_start();

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {

        $_SESSION["username"] = $row["username"];
        header("Location: profile.php");
        exit();
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Wrong email or password")';
        echo '</script>';
    }

    mysqli_close($con);
}
// var_dump($_SESSION); 
// echo'hindi to error check lang kung tama ba lumalabas na user';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Categories</title>
    <link rel="stylesheet" href="page_design.css">
</head>
<body>
<div id="navbar">
            <nav>
                <label class="logo"><a href="home.php">WorkItOut</a></label>
                <ul>
                    <li><a href = "home.php" class="nav-active">Home</a></li>
                    <li><a href = "Categories.php" class="nav-active">Categories</a></li>
                    <li><a href = "CaloCal.php" class="nav-active">Calculator</a></li>
                    <li><a href = "meal.php" class="nav-active">Meals</a></li>
                    <li><a href = "about.html" class="nav-active">About</a></li>
                </ul>
                <ul id="profile_bar">
            <?php if (isset($_SESSION['username'])) : ?>
                <li><a href="profile.php"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'not logged in'; ?></a></li>
                <li><a href="logout.php">Log out</a></li>

            <?php else : ?>
                <li><a href="signup.php">Sign up</a></li>
                <li><a href="login.php">Log in</a></li>
            <?php endif; ?>
                </ul>
            </nav>
        <hr>
        </div>


    <div class="container03">
        <div class="categories-holder">
            <h1>Workout Categories</h1>
            <div class="cat-card">
                <div class="categories-01">
                    <a href="cat_parts/beginner.php">Beginner</a>
                </div>
                <div class="categories-02">
                    <a href="cat_parts/intermediate.php">Intermediate</a>
                </div>
                <div class="categories-03">
                    <a href="cat_parts/advanced.php">Advanced</a>
                </div>
            </div>
        </div>
    </div>

    <hr style="margin-bottom: 250px;">

    <footer>
        <div class="footer-content">
            <p>&copy; 2023 WorkItOut</p>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function () {
            const footer = document.querySelector('footer');
            const scrollHeight = window.scrollY;
            const documentHeight = document.documentElement.scrollHeight - window.innerHeight;
    
            const opacity = 0.5 + (scrollHeight / documentHeight) * 0.5;
    
            footer.style.opacity = opacity.toFixed(2);
        });
    </script>

</body>
</html>