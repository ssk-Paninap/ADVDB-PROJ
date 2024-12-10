<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        $con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $exerciseName = $_POST['exerciseName'];
        $date_added = $_POST['exerciseDate'];

        $userId = isset($_SESSION["Id"]) ? $_SESSION["Id"] : null;

        if ($userId) {
            $querySelectExData = "SELECT ex_id, workout_name, workout_category FROM exercises WHERE workout_name = ?";
            $stmtSelectExData = mysqli_prepare($con, $querySelectExData);
            mysqli_stmt_bind_param($stmtSelectExData, "s", $exerciseName);
            mysqli_stmt_execute($stmtSelectExData);
            $resultSelectExData = mysqli_stmt_get_result($stmtSelectExData);

            if ($rowSelectExData = mysqli_fetch_assoc($resultSelectExData)) {
                $exId = $rowSelectExData['ex_id'];
                $workoutName = $rowSelectExData['workout_name'];
                $exerciseCategory = $rowSelectExData['workout_category'];

                $queryInsertWorkout = "INSERT INTO workouts (Id, exercise_id, exercise_name, exercise_category, date_added) VALUES (?, ?, ?, ?, ?)";
                $stmtInsertWorkout = mysqli_prepare($con, $queryInsertWorkout);

                if ($stmtInsertWorkout) {
                    mysqli_stmt_bind_param($stmtInsertWorkout, "iisss", $userId, $exId, $workoutName, $exerciseCategory, $date_added);

                    if (mysqli_stmt_execute($stmtInsertWorkout)) {
                        $lastInsertedId = mysqli_insert_id($con);
                        header("Location:../Categories.php");
                    } else {
                        echo "Error saving exercise: " . mysqli_error($con);
                    }

                    mysqli_stmt_close($stmtInsertWorkout);
                } else {
                    echo "Error preparing statement: " . mysqli_error($con);
                }
            } else {
                echo "Error fetching ex_id, workout_name, and workout_category: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmtSelectExData);
        } else {
            echo "Session content: ";
            print_r($_SESSION);
            echo "User not logged in.";
        }

        mysqli_close($con);
    } else {
        echo "User not logged in";
    }
} else {
    echo "Invalid request";
}
?>
