<?php

session_start();

$con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['daily_calorie_intake'])) {

        $dailyCalories = filter_input(INPUT_POST, 'daily_calorie_intake', FILTER_SANITIZE_NUMBER_INT);
        $activityLevel = filter_input(INPUT_POST, 'activity-level', FILTER_SANITIZE_STRING);

        $updateQuery = "UPDATE users SET daily_calorie_intake = ?, activity = ? WHERE username = ?";
        $updateStmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "iss", $dailyCalories, $activityLevel, $username);
        mysqli_stmt_execute($updateStmt);

        if(mysqli_stmt_affected_rows($updateStmt) > 0) {
            header("Location:profile.php");
            echo "Data updated successfully!";
        } else {
            echo "No changes made or error updating data.";
        }
    }
}

mysqli_close($con);

?>
