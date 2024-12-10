<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_meal = $_POST['id_meal'];
    $con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $stmt = $con->prepare('DELETE FROM meals WHERE id_meal = ?');
    $stmt->bind_param('i', $id_meal);
    $stmt->execute();

    $stmt->close();
    mysqli_close($con);

    header("Location:profile.php");
    
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}
?>

