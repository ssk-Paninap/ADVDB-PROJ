<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['Id'])) {
        $mealId = isset($_POST['id_meal']) ? $_POST['id_meal'] : null;

        $mealId = filter_var($mealId, FILTER_VALIDATE_INT);

        if ($mealId !== false && $mealId > 0) {

            $con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "DELETE FROM meals WHERE id_meal = ?";
            $stmt = mysqli_prepare($con, $sql);

            if (!$stmt) {
                die("Error in SQL query: " . mysqli_error($con));
            }
            mysqli_stmt_bind_param($stmt, "i", $mealId);
            mysqli_stmt_execute($stmt);

            mysqli_close($con);
            header("Location: meal.php");
            exit();
        } else {
            header("Location: meal.php");
        }
    } else {
        echo "User not logged in.";
    }
} else {
    echo "Form not submitted.";
}
?>
