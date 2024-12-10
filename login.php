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
        $_SESSION["Id"] = $row["Id"]; 
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
// echo 'wag muna tanggalin';
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgba(16, 102, 131, 0.30);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #ffffff;
            border: 1px solid #ffffff;
            padding: 20px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .login-container h2 {
            font-size: 24px;
            margin: 0 0 20px;
            font-weight:900;
        }

        .login-container input[type="text"],.login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        a {
            text-decoration: none;
            color: #4077b3;
        }
        a:hover {
            font-size:25px; 
            transition: font-size 0.3s ease; 
        }

        a ::after {
            color: #4077b3;
        }
        #btn1 {
            background-color: #4077b3;
        }
    </style>
    </style>
</head>
<body>
    <div class="login-container">
        <h2><a href = "home.php">WELCOME TO WORK IT OUT</a></h2>
        <form action="login.php" method="POST">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input id="btn1" type="submit" value="Login" name="login">
        </form>
        <h6><a href="signup.php">Create an account?</a></h6>
    </div>
</body>
</html>
