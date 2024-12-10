<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "work_it_out_proj";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['Id'])) {
    die("User ID not set in session.");
}

$userId = $_SESSION['Id'];
if (isset($_GET['delete_bmi'])) {
    $delBmiId = $_GET['del-bmi-id'];
    if (!is_numeric($delBmiId)) {
        header("Location: profile.php");
        exit;
    }

    $deleteQuery = "DELETE FROM update_hw WHERE Id = '$userId' AND count_id = '$delBmiId'";

    if ($conn->query($deleteQuery) === TRUE) {
        header("Location: profile.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
