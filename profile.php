<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    //TEXTBOXES VALUES FROM sign up to DB
    if ($row = mysqli_fetch_assoc($result)) {
        $startingWeight = $row['starting_weight'];
        $startingHeight = $row['starting_height'];
        $gender = $row['gender'];
        $currentWeight = $row['current_weight'];
        $currentHeight = $row['current_height'];
        $daily_calorie_intake = $row['daily_calorie_intake'];
        $age = $row['age'];
        $cur_bmi = $row['bmi'];

        $loggedInUserID = $row['Id']; 
        $queryUpdateHW = "SELECT height, weight FROM update_hw WHERE Id = ?";
        $stmtUpdateHW = mysqli_prepare($con, $queryUpdateHW);
        mysqli_stmt_bind_param($stmtUpdateHW, "i", $loggedInUserID);
        mysqli_stmt_execute($stmtUpdateHW);
        $resultUpdateHW = mysqli_stmt_get_result($stmtUpdateHW);

        $dataUpdateHW = [];

        while ($rowUpdateHW = mysqli_fetch_assoc($resultUpdateHW)) {
            $dataUpdateHW[] = [
                'height' => $rowUpdateHW['height'],
                'weight' => $rowUpdateHW['weight'],
            ];
        }

        mysqli_stmt_close($stmtUpdateHW);
        $dsn = 'mysql:host=localhost;dbname=work_it_out_proj';
        $dbUsername = 'root';
        $dbPassword = '';

        try {
            $pdo = new PDO($dsn, $dbUsername, $dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //show ecxercise for table below
            $stmt = $pdo->prepare('SELECT exercise_id, exercise_name, exercise_count, exercise_category, date_added FROM workouts WHERE Id = :Id');
            $stmt->bindParam(':Id', $loggedInUserID, PDO::PARAM_INT);
            $stmt->execute();

            $chosenExercises = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //show meals of user 
            $stmtMeals = $pdo->prepare('SELECT id_meal, meal_name, meal_category, amount_of_protein, amount_of_carbs FROM meals WHERE Id = :Id');
            $stmtMeals->bindParam(':Id', $loggedInUserID, PDO::PARAM_INT);
            $stmtMeals->execute();

            $chosenMeals = $stmtMeals->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    } else {
        $username = "GUEST0123456";
    }
}

mysqli_close($con);
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link rel = "stylesheet" href="page_design.css">
        <style>
             #editForm {
            display: <?php echo isset($_SESSION['show_edit_form']) && $_SESSION['show_edit_form'] ? 'block' : 'none'; ?>;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }
        </style>
    </head>
    <body>
        <div id="navbar">
            <nav>
                <label class="logo"><a href="home.php">WorkItOut</a></label>
                <ul>
                    <li><a href = "home.php" class="nav-active">Home</a></li>
                    <li><a href = "Categories.php" class="nav-active">Categories</a></li>
                    <li><a href = "CaloCal.php" class="nav-active">Calculator</a></li>
                    <li><a href = "meal.php" class="nav-active">Meals</a></li>
                    <li><a href = "about.html" class="nav-active">About</a></li>
                </ul>
                <ul id="profile_bar">
                    <?php if (isset($_SESSION['username'])) : ?>
                        <li><a href="profile.php"><?php echo isset($username) ? $username : 'not logged in'; ?></a></li>
                        <li><a href="logout.php">Log out</a></li>
                    <?php else : ?>
                        <li><a href="signup.php">Sign up</a></li>
                        <li><a href="login.php">Log in</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        <hr>
        </div>
        <div id="username-holder">
            <div class="username-container">
                <h1><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'GUEST0123456'; ?></h1>
            </div>
            <h6><a href="javascript:void(0);" onclick="showEditForm()">edit username</a></h6>
        </div>
        <div id="editForm">
            <form action="edit_username.php" method="post" id="editrForm">
                <label for="newUsername">New Username:</label>
                <input type="text" id="newUsername" name="newUsername" required>
                <br>
                <input type="submit" value="Submit">
            </form>
            <button onclick="hideEditForm()">Close</button>
        </div>

        <script>
            function showEditForm() {
                document.getElementById('editForm').style.display = 'block';
            }

            function hideEditForm() {
                document.getElementById('editForm').style.display = 'none';
            }
        </script>

    <div class="profile-contents">
        <form method="POST" action="update_profile.php">
            <div class="profile-row">
                <div class="profile-item">
                    <label>Starting Weight:</label>
                    <input name="starting_weight" type="text" id="textbox1" value="<?php echo isset($startingWeight) ? $startingWeight : 'N/A'; ?>" readonly>
                </div>
                <div class="profile-item">
                    <label>Starting Height:</label>
                    <input name="starting_height" type="text" id="textbox2" value="<?php echo isset($startingHeight) ? $startingHeight : 'N/A'; ?>" readonly>
                </div>
                <div class="profile-item">
                    <label>Gender:</label>
                    <input name="gender" type="text" id="textbox3" value="<?php echo isset($gender) ? $gender : 'N/A'; ?>" readonly>
                </div>
                <div class="profile-item">
                    <label>Age:</label>
                    <input name="age" type="text" id="textbox7" value="<?php echo $age; ?>" readonly>
                </div>
            </div>

            <div class="profile-row" id="bottom-row-prof">
                <div class="profile-item">
                    <label>Current Weight:</label>
                    <input name="current_weight" type="text" id="textbox4" value="<?php echo isset($currentWeight) ? $currentWeight : 'N/A'; ?>">
                </div>
                <div class="profile-item">
                    <label>Current Height:</label>
                    <input name="current_height" type="text" id="textbox5" value="<?php echo isset($currentHeight) ? $currentHeight : 'N/A'; ?>">
                </div>
                <div class="profile-item">
                    <label>Daily Calorie Intake:</label>
                    <input name="daily_calorie_intake" type="text" id="textbox6" readonly value="<?php echo isset($daily_calorie_intake) ? $daily_calorie_intake : 'N/A'; ?>">
                </div>
                <div class="profile-item">
                    <label>Current BMI:</label>
                    <input name="cur_bmi" type="text" id="cur_bmi" value="<?php echo isset($cur_bmi) ? $cur_bmi : 'N/A'; ?>">
                </div>
            </div>

            <div class="profile-buttons">
                <button type="button" id="update-button" onclick="updateProfile()">Update</button>
                <button type="submit" name="saveProfile">Save</button>
            </div>
        </form>
    </div>

    <div class="mid-contain">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            
            <div style="height: 300px; overflow: auto;background-color:azure;gap:5;">
                <canvas id="weightChart"></canvas>
            </div>

            <div style="height: 300px; overflow: auto; background-color:azure;gap:5;">
                <canvas id="heightChart"></canvas>
            </div>

    </div>

        <script>
            var heightValuesUpdateHW = <?php echo json_encode(array_column($dataUpdateHW, 'height')); ?>;
            var weightValuesUpdateHW = <?php echo json_encode(array_column($dataUpdateHW, 'weight')); ?>;

            var heightConfig = {
                type: 'line',
                data: {
                    labels: Array.from({ length: heightValuesUpdateHW.length }, (_, i) => i + 1),
                    datasets: [{
                        label: 'Height (cm)',
                        data: heightValuesUpdateHW,
                        borderColor: 'blue',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            var weightConfig = {
                type: 'line',
                data: {
                    labels: Array.from({ length: weightValuesUpdateHW.length }, (_, i) => i + 1),
                    datasets: [{
                        label: 'Weight (kg)',
                        data: weightValuesUpdateHW,
                        borderColor: 'green',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            var heightCtxUpdateHW = document.getElementById('heightChart').getContext('2d');
            var weightCtxUpdateHW = document.getElementById('weightChart').getContext('2d');

            var heightChartUpdateHW = new Chart(heightCtxUpdateHW, heightConfig);
            var weightChartUpdateHW = new Chart(weightCtxUpdateHW, weightConfig);
        </script>
       
    </div>

        </div>
        
    <div id="routine-table" class="prof-stats-tab">
    <?php if (isset($chosenExercises) && !empty($chosenExercises)): ?>
        <h1>These are your workouts added:</h1>
        <table class="exercise-table prof-tables" id="exerciseTable">
            <thead>
                <tr>
                    <th class="exercise-th tab-items">Exercise Id</th>
                    <th class="exercise-th tab-items">Exercise Name</th>
                    <th class="exercise-th tab-items">Exercise Count</th>
                    <th class="exercise-th tab-items">Exercise Category</th>
                    <th class="exercise-th tab-items">Date Added</th>
                    <th class="exercise-th tab-items">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chosenExercises as $exercise): ?>
                    <tr>
                        <td><?php echo $exercise['exercise_id']; ?></td>
                        <td><?php echo $exercise['exercise_name']; ?></td>
                        <td><?php echo $exercise['exercise_count']; ?></td>
                        <td><?php echo $exercise['exercise_category']; ?></td>
                        <td><?php echo $exercise['date_added']; ?></td>
                        <td>
                           
                            <div class="btn_ctr">
                                <form method="post" action="update_exercise.php" onsubmit="return confirm('Are you sure you want to update this exercise count?');">
                                    <input type="hidden" name="exercise_id" value="<?php echo $exercise['exercise_id']; ?>">
                                    <input type="number" name="new_count" placeholder="Enter new count" required>
                                    <div class="btn-holder"><button type="submit" class="edit-count-btn">save edit</button></div>
                                </form>

                                
                                <form method="post" action="delete_exercise.php" onsubmit="return confirm('Are you sure you want to delete this exercise?');">
                                    <input type="hidden" name="exercise_id" value="<?php echo $exercise['exercise_id']; ?>">
                                    <div class="btn-holder"><button type="submit" class="remove-exercise-btn">Delete</button></div>
                                </form>
                            
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No exercises found.</p>
    <?php endif; ?>

    <script>
        function editExerciseCount(exerciseId) {
            var newCount = prompt('Enter the new count:');
            if (newCount !== null) {
                window.location.href = 'update_exercise.php?exercise_id=' + exerciseId + '&new_count=' + newCount;
            }
        }
    </script>
</div>

<div id="meal-prof-table" class="prof-stats-tab">
    <h1>Meals added:</h1>
    <table class="meal-table prof-tables" id="mealTable">
        <thead>
        <tr>
            <th class="meal-th tab-items">ID</th>
            <th class="meal-th tab-items">Meal</th>
            <th class="meal-th tab-items">Meal Category</th>
            <th class="meal-protein tab-items">Amount of Protein</th>
            <th class="meal-carbs-count tab-items">Carbs Count</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($chosenMeals as $meal) : ?>
            <tr>
                <td><?php echo $meal['id_meal']; ?></td>
                <td><?php echo $meal['meal_name']; ?></td>
                <td><?php echo $meal['meal_category']; ?></td>
                <td><?php echo $meal['amount_of_protein']; ?></td>
                <td><?php echo $meal['amount_of_carbs']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <form method="post" action="meal_delete.php" onsubmit="return confirmDelete();">
    <input type="hidden" name="id_meal" id="id_meal" value="<?php echo $meal['id_meal']; ?>">
    <button type="submit" class="remove-exercise-btn">Delete</button>
</form>

<script>
    function confirmDelete() {
        var userInput = prompt('Enter the ID you want to delete:'); 
        if (userInput !== null) {
            document.getElementById('id_meal').value = userInput;
            return true;
        } else {
            return false;
        }
    }
</script>

    </div>
    
    </div>
<h1 style="margin-left:50px;margin-right:50px;border:solid 10px azure;border-radius: 10px;padding:10px;background-color:azure;">BODY MASS INDEX</h1>
    <div class="bmi-calculator">
        <h3>CALCULATE BMI</h3>
            <!-- <button id="edit-bmi-button" class="bmi-button" onclick="editBMI()">Edit</button> -->
        <form method="POST" action="save_bmi.php">
            <div class="bmi-results" class="bmi-cont">
                <div>
                <label>Your BMI:</label>
                <input type="text" id="bmi" class="bmi-part">
                </div>
        
                <div  class="bmi-cont">
                <label>Result:</label>
                <input type="text" id="bmi-category" class="bmi-part">
                </div>
            </div>
        
            <div class="bmi-inputs">
                <label>Weight (kg):</label>
                <input type="text" name="weight" id="weight">
        
                <label>Height (cm):</label>
                <input type="text" name="height" id="height">
        
                <div class="bmi_age_date">
                <label>Age:</label>
                <input type="text" name="age" id="age">

                <label>Date:</label>
                <input type="date" name="entryDate" id="entryDate">

                </div>
            </div>

            <button type="submit"name="save-bmi-button"  id="save-bmi-button" class="bmi-button" onclick="saveBMI(event)">Save</button>
            <button id="use-existing-btn" class="bmi-button" onclick="useExistingData(event)">Use existing data</button>
        </form>
        
        <h4 style="text-align: center;padding:10px;">BMI RECORDS</h4>   
            <div class="scrollable-table">

            <table id="bmi-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>BMI</th>
            <th>Category</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $conn = new mysqli('localhost', 'root', '', 'work_it_out_proj');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $userId = $_SESSION['Id'];

        // Modified SQL query to filter out rows with 0, empty, or '00-00-0000'
        $sql = "SELECT count_id, bmi, bmi_category, bmi_date FROM update_hw 
                WHERE Id = '$userId' 
                AND bmi != 0 AND bmi_category != '' AND bmi_date != '00-00-0000'";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['count_id'] . "</td>";
                echo "<td>" . $row['bmi'] . "</td>";
                echo "<td>" . $row['bmi_category'] . "</td>";
                echo "<td>" . $row['bmi_date'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No BMI records found.</td></tr>";
        }

        $conn->close();
        ?>
    </tbody>
</table>



            </div>
            <form method="get" action="delete_bmi.php">
                <label for="del-bmi-id">type the row id:</label>
                <input type="text" name="del-bmi-id" id="del-bmi-id">
                <input type="submit" value="remove"name="delete_bmi">
            </form>
        </div>
</div>
    </div>

    <footer>
        <div class="footer-content">
            <p>&copy; 2023 WorkItOut</p>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
    </footer>
    
    <script>        
        // //BMI AREA 
        // let isEditing = false;

        // function editBMI() {
        //     isEditing = true;
        //     const weightInput = document.getElementById('weight');
        //     const heightInput = document.getElementById('height');
        //     const ageInput = document.getElementById('age');
        //     const bmiInput = document.getElementById('bmi');
        //     const resultInput = document.getElementById('BMI-result');
        //     const editButton = document.getElementById('edit-bmi-button');
        //     const saveButton = document.getElementById('save-bmi-button');

        //     weightInput.readOnly = false;
        //     heightInput.readOnly = false;
        //     ageInput.readOnly = false;
        //     bmiInput.value = '';
        //     resultInput.value = '';
        //     editButton.disabled = true;
        //     saveButton.disabled = false;
        // }
        function setCurrentDate() {
            const currentDate = new Date().toISOString().split('T')[0];  // Get current date in "YYYY-MM-DD" format
            document.getElementById('entryDate').value = currentDate;
        }

        //date part
        window.onload = function () {
            setCurrentDate();
        };

        function saveBMI() {
            const weightInput = document.getElementById('weight');
            const heightInput = document.getElementById('height');
            const ageInput = document.getElementById('age');
            const bmiInput = document.getElementById('bmi');
            const resultInput = document.getElementById('bmi-category');
            const entryDateInput = document.getElementById('entryDate');

            const weight = parseFloat(weightInput.value);
            const height = parseFloat(heightInput.value);
            const age = parseInt(ageInput.value);
            const bmiDate = entryDateInput.value; 

            if (isNaN(weight) || isNaN(height) || isNaN(age)) {
                alert("Please enter valid weight, height, and age.");
                return;
            }

            const confirmation = confirm("Save now?");
            
            if (confirmation) {
                const bmi = calculateBMI(weight, height);
                const category = getBMICategory(bmi);

                addEntryToTable(weight, height, age, bmi, category, bmiDate);

                bmiInput.value = bmi.toFixed(2);
                resultInput.value = category;
                weightInput.readOnly = true;
                heightInput.readOnly = true;
                ageInput.readOnly = true;
            } else {
                console.log("saving is canceled by the user.");
            }
        }
        //BUTTON FUNC TO GET VALUES NA NASA PROFILE AREA SA TAAS
        function useExistingData(event) {
            event.preventDefault(); 

            const existingHeight = document.getElementById('textbox5').value;
            const existingWeight = document.getElementById('textbox4').value;
            const existingAge = document.getElementById('textbox7').value;

            document.getElementById('weight').value = existingWeight;
            document.getElementById('height').value = existingHeight;
            document.getElementById('age').value = existingAge;
        }

        
        function calculateBMI(weight, height) {
            const heightInCMeters = height / 100;

            // Calculate BMI
            return weight / (heightInCMeters * heightInCMeters);
        }

        function getBMICategory(bmi) {
            if (bmi < 18.5) return 'Underweight';
            else if (bmi >= 18.5 && bmi < 24.9) return 'Healthy';
            else return 'Overweight';
        }

        //TABLE AREA SA ILALIM NG BMI CALCU

        function addEntryToTable(weight, height, age, bmi, category, bmiDate) {
            const bmiTable = document.getElementById('bmi-table').getElementsByTagName('tbody')[0];
            const row = bmiTable.insertRow(0);
            const cellWeight = row.insertCell(0);
            const cellHeight = row.insertCell(1);
            const cellAge = row.insertCell(2);
            const cellBMI = row.insertCell(3);
            const cellCategory = row.insertCell(4);
            const cellDate = row.insertCell(5); // Add a new cell for the date

            cellWeight.textContent = weight;
            cellHeight.textContent = height;
            cellAge.textContent = age;
            cellBMI.textContent = bmi.toFixed(2);
            cellCategory.textContent = category;
            cellDate.textContent = bmiDate; // Set the date value

            if (bmiTable.rows.length > 5) {
                bmiTable.style.maxHeight = '150px';
                bmiTable.style.overflowY = 'scroll';
            }
        }
        //Profile area button 
        function updateProfile() {
            const textboxes = document.querySelectorAll('.profile-item input');
            textboxes.forEach((textbox, index) => {
              if (index > 2) {
                textbox.readOnly = false;
                textbox.classList.add('editable'); 
              }
            });
          }
          
          function saveEditinProfile() {
            const textboxes = document.querySelectorAll('.profile-item input');
            textboxes.forEach(textbox => {
              textbox.readOnly = true;
              textbox.classList.remove('editable'); 
            });
          }
</script>
</body>
</html>