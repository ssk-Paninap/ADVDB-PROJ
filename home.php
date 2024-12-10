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
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Welcome to Work it out</title>
    <link rel = "stylesheet" href="page_design.css">
</head>
<body>
<div id="wrapper">
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
    
    

    <!-- MAIN CARDS -->
    <div class="main-container">
        <div class="maincard">
            <div class="main-intro">
                <p>Welcome to <span>WORK IT OUT</span>, your ultimate destination for fitness and 
                    nutrition inspiration. Here, we offer a treasure trove of carefully curated workouts 
                    and meal planning ideas to help you on your journey to a healthier you. Our goal is to 
                    empower you with the knowledge and tools needed to achieve your fitness and dietary 
                    aspirations, making your path to wellness both achievable and enjoyable. We believe that 
                    fitness is not just a physical endeavor; it's a holistic journey that encompasses mental 
                    and emotional well-being. Let us be your trusted guide as you embark on this exciting voyage 
                    to a happier and healthier lifestyle.</p>
            </div>
            
        </div>
        <hr>
        <div class="container01">
            <div class="card">
                <div id="card-01">
                    <a href="Categories.php">Workouts</a>
                    <p>See workouts available and see how it is properly made</p>
                </div>
            </div>
            <div class="card">
                <div id="card-03">
                    <a href="meal.php">Meal Plans</a>
                    <p>See pre-made meal plan that you can use as a guide for your diet plan</p>
                </div>
            </div>
            <div class="card">
                <div id="card-04">
                    <a href="CaloCal.php">Calorie Calculator</a>
                    <p>Use the Calorie Calculator to find out how much calorie your body needs.</p>
                </div>
            </div>
        </div>
        <hr>
        <div class="site-goals">
            <div class="goals-content">
                <p>Our website's primary aim is to share knowledge and inspire those striving for a healthy and balanced lifestyle through physical 
                    fitness. We understand that this journey can seem daunting, filled with uncertainties and challenges. Our platform offers expertly 
                    crafted workout routines and comprehensive nutritional advice to provide you with the tools needed to make informed choices and reach your wellness goals. 
                    We believe that fitness encompasses both physical and mental well-being, and our content aims to motivate you to take charge of your health, boost your confidence, 
                    and embrace an active, balanced lifestyle. Let our website be your trusted companion on your path to a healthier, happier you.
                </p>
                <div class="mini-img">
                    <img src="img/dumbbell.png">
                    <img src="img/plato.png">
                </div>
                
            </div>
        </div>
    </div>
        
</div>

<hr style="margin-bottom: 25px;">

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

    
</body>
</html>