<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exerciseId = $_POST['exercise_id'];
    $con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $newCount = $_POST['new_count']; 

    $stmt = $con->prepare('UPDATE workouts SET exercise_count = ? WHERE exercise_id = ?');
    $stmt->bind_param('ii', $newCount, $exerciseId);
    $stmt->execute();

    if ($stmt->error) {
        die('Error executing query: ' . $stmt->error);
    }

    $stmt->close();
    mysqli_close($con);

    header("Location: profile.php");
    exit;

} 

?>
