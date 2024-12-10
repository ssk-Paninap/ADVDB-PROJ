<?php
include('profile.php');
$con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['saveProfile'])) {
    $currentHeight = isset($_POST['current_height']) ? $_POST['current_height'] : $currentHeight;
    $currentWeight = isset($_POST['current_weight']) ? $_POST['current_weight'] : $currentWeight;
    $age = isset($_POST['age']) ? $_POST['age'] : 'N/A';
    $username = $_SESSION['username'];

    // Update users table
    $queryUsers = "UPDATE users SET current_height = COALESCE(?, current_height), current_weight = COALESCE(?, current_weight), age = ? WHERE username = ?";

    $stmtUsers = mysqli_prepare($con, $queryUsers);
    mysqli_stmt_bind_param($stmtUsers, "ddss", $currentHeight, $currentWeight, $age, $username);

    if (mysqli_stmt_execute($stmtUsers)) {
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmtUsers);

    // Insert into update_hw table
    $queryUpdateHW = "INSERT INTO update_hw (height, weight, Id) VALUES (?, ?, ?)";

    $stmtUpdateHW = mysqli_prepare($con, $queryUpdateHW);
    mysqli_stmt_bind_param($stmtUpdateHW, "dds", $currentHeight, $currentWeight, $loggedInUserID); 

    if (mysqli_stmt_execute($stmtUpdateHW)) {
        mysqli_stmt_close($stmtUpdateHW);
        echo "<script>window.location.href='home.php';</script>";
            exit();
    } else {
        echo "Error inserting data into update_hw: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmtUpdateHW);
}

mysqli_close($con);
?>
