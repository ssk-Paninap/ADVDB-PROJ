<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exerciseId = $_POST['exercise_id'];
    $con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $stmt = $con->prepare('DELETE FROM workouts WHERE exercise_id = ?');
    $stmt->bind_param('i', $exerciseId);
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

