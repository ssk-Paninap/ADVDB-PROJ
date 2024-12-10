<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$autofillData = array(
    'gender' => '',
    'weight' => '',
    'height' => '',
    'age' => ''
);

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    }

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $autofillData['gender'] = $row['gender'];
        $autofillData['weight'] = $row['current_weight'];
        $autofillData['height'] = $row['current_height'];
        $autofillData['age'] = $row['age'];
    }
}

mysqli_close($con);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calorie Calculator</title>
    <link rel="stylesheet" href="page_design.css">
    <style>
.container02 {
    text-align: center;
    background-image: url(img/calocalcu.jpg);
    background-color: rgba(85, 121, 120, 0.5); 
    background-blend-mode: overlay;
    background-size: cover;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    margin: 0 auto; 
    max-width: 600px; 
    margin-top: 20px;
}
.btn-container {
    display: inline-flex;
    gap: 10px;
}

h1 {
    color: #000000;
}

form {
    margin:30px;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    padding: 10px;
}

input[type="radio"],input[type="number"],select {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

button {
    background-color: #3a5f86;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}
.gender-box {
    width: 300px;
    display: flex;
    margin-left: 100px;
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
        <li><a href="profile.php"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'not logged in'; ?></a></li>
        <li><a href="logout.php">Log out</a></li>

    <?php else : ?>
        <li><a href="signup.php">Sign up</a></li>
        <li><a href="login.php">Log in</a></li>
    <?php endif; ?>
        </ul>
    </nav>
        <hr>
</div>
    <div class="container02">
        <h1>Calorie Calculator</h1>
    <form id="calorie-form" method="POST" action="save_calories.php">
    <label for="gender"style = "margin-right:10px;">Gender:</label>
        <div class="gender-box">
        
        <input type="radio" name="gender" value="male" id="male-radio" required>

        <label for="male-radio">Male</label>
        
        <input type="radio" name="gender" value="female" id="female-radio">
        <label for="female-radio">Female</label>
        <br>

        </div>
        
        <label for="age">Age (years):</label>
        <input type="number" name="age" id="age-input" required>
        <br>

        <label for="weight">Weight (kg):</label>
        <input type="number" name="weight" id="weight-input" required>
        <br>

        <label for="height">Height (cm):</label>
        <input type="number" name="height" id="height-input" required>
        <br>

        <label for="activity-level">Activity Level:</label>
        <select name="activity-level" id="activity-level-select" required>
            <option value="sedentary">Sedentary (little or no exercise)</option>
            <option value="lightly-active">Lightly active (light exercise/sports 1-3 days/week)</option>
            <option value="moderately-active">Moderately active (moderate exercise/sports 3-5 days/week)</option>
            <option value="very-active">Very active (hard exercise/sports 6-7 days a week)</option>
            <option value="super-active">Super active (very hard exercise & physical job or training)</option>
        </select>
        <br>

        <button type="button" id="calculate-button" onclick="calculateCalories()">Calculate</button>
        <input type="hidden" name="daily_calorie_intake" id="daily_calorie_intake" value="">
        <button type="submit" id="save-button" name="save" onclick="saveFormData()">Save</button>
        <button type="button" id="use-existing-data-button" onclick="useExistingData()">Use Existing Data</button>

    </form>
        <label for="result">
            ESTIMATED CALORIE NEEDED DAILY
            <input type="text" id="result" readonly>
        </label>
        
    
    </div>
    <hr style="margin-bottom: 250px;">
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
    function calculateCalories() {
        const gender = document.querySelector('input[name="gender"]:checked').value;
        const age = parseInt(document.getElementById('age-input').value);
        const weight = parseFloat(document.getElementById('weight-input').value);
        const height = parseFloat(document.getElementById('height-input').value);
        const activityLevel = document.getElementById('activity-level-select').value;

        let calorieFactor;
        switch (activityLevel) {
            case 'sedentary':
                calorieFactor = 1.2;
                break;
            case 'lightly-active':
                calorieFactor = 1.375;
                break;
            case 'moderately-active':
                calorieFactor = 1.55;
                break;
            case 'very-active':
                calorieFactor = 1.725;
                break;
            case 'super-active':
                calorieFactor = 1.9;
                break;
            default:
                calorieFactor = 1;
        }
        let bmr;
        if (gender === 'male') {
            bmr = 88.362 + (13.397 * weight) + (4.799 * height) - (5.677 * age);
        } else {
            bmr = 447.593 + (9.247 * weight) + (3.098 * height) - (4.330 * age);
        }
        const dailyCalories = Math.round(bmr * calorieFactor);

        document.getElementById('daily_calorie_intake').value = dailyCalories;
        const resultInput = document.getElementById('result');
        resultInput.value = dailyCalories;
    }

    function saveFormData() {
        calculateCalories();
        const calorieForm = document.getElementById('calorie-form');
        calorieForm.submit();
    };
        var autofillData = <?php echo json_encode($autofillData); ?>;

        function useExistingData() {
            document.getElementById('weight-input').value = autofillData.weight;
            document.getElementById('weight-input').value = autofillData.weight;
            document.getElementById('height-input').value = autofillData.height;
            document.getElementById('age-input').value = autofillData.age;

            var gender = autofillData.gender.toLowerCase(); 
            document.getElementById(gender + '-radio').checked = true;
            alert('Existing data has been autofilled.');
        }
    </script>

</body>
</html>
