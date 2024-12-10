<?php //signup process to
header('Location: login.php');

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST["password"];
$age = $_POST['age'];
$starting_weight = $_POST['starting_weight'];
$starting_height = $_POST['starting_height'];
$gender = $_POST['gender'];

$conn = new mysqli('localhost', 'root', '', 'work_it_out_proj');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, age, starting_weight, starting_height, gender) values (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiss", $username, $email, $password, $age, $starting_weight, $starting_height, $gender);

    $stmt->execute();
    echo "Registration success";
    $stmt->close();
    $conn->close();
}
?>
