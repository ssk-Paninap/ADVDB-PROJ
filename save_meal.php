<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['Id'];
    $mealName = $_POST['meal_name'];
    $mealCategory = $_POST['meal_category'];
    $con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected successfully<br>";

    $food = mysqli_real_escape_string($con, $_POST['meal_name']);

    $queryCheck = "SELECT meal_id FROM meals WHERE Id = ? AND meal_name = ?";
    $stmtCheck = $con->prepare($queryCheck);
    $stmtCheck->bind_param('is', $userId, $food);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if (!$resultCheck) {
        echo "Error checking if meal exists: " . mysqli_error($con);
    } else {
        if ($resultCheck->num_rows > 0) {
            header("Location: meal.php");
            exit();
        }
    }

    $stmtCheck->close();
    $query = "SELECT meal_id, amount_of_protein, amount_of_carbs FROM meal_list WHERE meal_name = ?";
    $stmtQuery = $con->prepare($query);
    $stmtQuery->bind_param('s', $food);
    $stmtQuery->execute();
    $resultQuery = $stmtQuery->get_result();

    if (!$resultQuery) {
        echo "Error fetching meal_id, protein, and carbs: " . mysqli_error($con);
    } else {
        if ($resultQuery->num_rows > 0) {
            $row = $resultQuery->fetch_assoc();
            $mealId = $row['meal_id'];
            $proteinAmount = $row['amount_of_protein'];
            $carbsAmount = $row['amount_of_carbs'];
        } else {
            echo "No matching meal found for: " . $food;
            exit(); 
        }
    }

    $stmtQuery->close();
    $stmt = $con->prepare('INSERT INTO meals (Id, meal_name, meal_category, amount_of_protein, amount_of_carbs, id_meal) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('issiii', $userId, $mealName, $mealCategory, $proteinAmount, $carbsAmount, $mealId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: meal.php");
    } else {
        echo "Error adding meal: " . $stmt->error;
    }

    $stmt->close();
    mysqli_close($con);
}
?>
