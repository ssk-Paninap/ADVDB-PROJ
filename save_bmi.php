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

if (!isset($_POST['weight'], $_POST['height'], $_POST['age'], $_POST['entryDate'])) {
    die("Incomplete data received.");
}
$weight = $_POST['weight'];
$height = $_POST['height'];
$age = $_POST['age'];
$bmiDate = $_POST['entryDate'];

if (empty($weight) || empty($height) || !is_numeric($weight) || !is_numeric($height)) {
    header("Location: profile.php");
    exit;
}
function calculateBMI($weight, $height) {
    $heightInMeters = $height / 100;
    return $weight / ($heightInMeters * $heightInMeters);
}
function getBMICategory($bmi) {
    if ($bmi < 18.5) return 'Underweight';
    else if ($bmi >= 18.5 && $bmi < 24.9) return 'Healthy';
    else return 'Overweight';
}
if (!empty($weight) && !empty($height) && is_numeric($weight) && is_numeric($height)) {
    $bmi = calculateBMI($weight, $height);
    $bmiCategory = getBMICategory($bmi);

    $updateUsersQuery = "UPDATE users SET bmi = '$bmi', bmi_category = '$bmiCategory' WHERE Id = '$userId'";
    if ($conn->query($updateUsersQuery) !== TRUE) {
        header("Location: profile.php");
        exit;
    }

    $insertUpdateHWQuery = "INSERT INTO update_hw (height, weight, Id, bmi, bmi_category, bmi_date) VALUES ('$height', '$weight', '$userId', '$bmi', '$bmiCategory', '$bmiDate') ";
    if ($conn->query($insertUpdateHWQuery) !== TRUE) {
        header("Location: profile.php");
        exit;
    }
}

$conn->close();
header("Location: profile.php");
exit;
?>