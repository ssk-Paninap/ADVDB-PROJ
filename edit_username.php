<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newUsername = $_POST["newUsername"];

    $newUsername = htmlspecialchars(trim($newUsername));

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "work_it_out_proj";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $userId = $_SESSION['Id']; 
    $updateQuery = "UPDATE users SET username = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $newUsername, $userId);

    if ($stmt->execute()) {
        $_SESSION['username'] = $newUsername;
        header("Location: home.php");
        exit();
    } else {
        echo "Error updating username: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: profile.php");
    exit();
}
?>
