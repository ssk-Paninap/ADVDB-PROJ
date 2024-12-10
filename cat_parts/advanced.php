<?php
session_start();

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $con = mysqli_connect("localhost", "root", "", "work_it_out_proj");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION["Id"] = $row["Id"];
        $_SESSION["username"] = $row["username"];
        header("Location: profile.php");
        exit();
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Wrong email or password")';
        echo '</script>';
    }
    mysqli_close($con);
}
// var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Workouts</title>
    <link rel="stylesheet" href="../page_design.css">
</head>
<body>
<div id="navbar">
    <nav>
        <label class="logo"><a href="../home.php">WorkItOut</a></label>
        <ul>
            <li><a href = "../home.php" class="nav-active">Home</a></li>
            <li><a href = "../Categories.php" class="nav-active">Categories</a></li>
            <li><a href = "../CaloCal.php" class="nav-active">Calculator</a></li>
            <li><a href = "../meal.php" class="nav-active">Meals</a></li>
            <li><a href = "../about.html" class="nav-active">About</a></li>
        </ul>
        <ul id="profile_bar">
    <?php if (isset($_SESSION['username'])) : ?>
        <li><a href="../profile.php"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'not logged in'; ?></a></li>
        <li><a href="../logout.php">Log out</a></li>

    <?php else : ?>
        <li><a href="../signup.php">Sign up</a></li>
        <li><a href="../login.php">Log in</a></li>
    <?php endif; ?>
        </ul>
    </nav>
        <hr>
</div>

    <div class="container04">
        <h1>Advanced Workouts that you can try...</h1>
        <div class="beginner_container">
            <div class="ex_card">
                <div class="slide active" class="item-1">
                    <h2>DEADLIFT</h2>
                <span><ul>
                        <li>begin with your feet shoulder-width apart, the barbell over the middle of your feet, and your toes pointing forward.</li>
                        <li>Bend at the hips and knees to lower yourself to the bar with a flat back and a tight core.</li>
                        <li>Grip the bar with your hands slightly wider than shoulder-width apart, using either a double overhand or mixed grip. </li>
                        <li>Maintain a neutral spine, chest up, and shoulders back.</li>
                        <li>Drive through your heels, extending your hips and knees simultaneously to lift the bar. </li>
                        <li>Keep the bar close to your body throughout the lift and stand tall while maintaining a neutral spine. Reverse the motion by hinging at the hips and lowering the bar with control.</li>
                    </ul>
                    <p>Duration: Deadlifts are typically performed for 3-5 sets of 5-8 reps, depending on your training goals (strength, power, or hypertrophy).
                        Proper form is crucial to prevent injury. Ensure your back remains flat, engage your lats, and keep the bar close to your body.
                        Use a weightlifting belt to support your lower back when lifting heavy loads.
                        Warm up with lighter weights to prepare your muscles and joints.
                        Maintain a controlled tempo, avoiding jerky movements.</p>
                <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Deadlift')">
                <input type="button" value="see" class="ex-btn" id="seeGif1" ondblclick="unSee('showGif')">

                </div>

                <div class="showGif" class="exerbox" style="margin: bottom 10px;">

                </div>
                <div id="exerciseFormDeadlift" class="ex-form-des" style="display: none; margin: bottom 50px;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameDeadlift">Add Exercise:</label>
                    <input type="text" id="exerciseNameDeadlift" name="exerciseName" required><br><br>

                    <label for="exerciseDateDeadlift">Date of Adding:</label>
                    <input type="date" id="exerciseDateDeadlift" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDateDeadlift').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Deadlift')">Cancel</button>
                </form>

                </div>
                <br>
            <div class="slide" class="item-2">
                <h2>BURPEES</h2>
                <p>Burpees are a full-body exercise that involves a series of movements. To perform a burpee, start in a standing position, then quickly drop into a squat, 
                    place your hands on the ground, and kick your feet back into a plank position. Next, jump your feet back to the squat position and explosively jump up,
                     reaching your arms overhead. The duration for a set of<b> burpees typically ranges from 30 seconds to 1 minute</b>, depending on your fitness level and workout 
                     goals.</p>
                     <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Burpees')">
                     <input type="button" value="see" class="ex-btn" id="seeGif2" ondblclick="unSee('showGif2')">

            </div>
            <div class="showGif2" class="exerbox" style="margin-bottom:10px ;">

            </div>

            <div id="exerciseFormBurpees" class="ex-form-des" style="display: none; margin: bottom 50px;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameBurpees">Add Exercise:</label>
                    <input type="text" id="exerciseNameBurpees" name="exerciseName" required><br><br>

                    <label for="exerciseDateBurpees">Date of Adding:</label>
                    <input type="date" id="exerciseDateBurpees" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDateBurpees').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Burpees')">Cancel</button>
                </form>
            </div>

            <br>

            <div class="slide" class="item-3">
                <h2>Kettlebell Swings</h2>
                <p>The kettlebell swing is a dynamic full-body exercise that targets various muscle groups, including the hips, glutes, hamstrings, lower back, and shoulders. 
                    
                    To perform a kettlebell swing:
                </p>
                <p>
                    Stand with your feet shoulder-width apart and place a kettlebell on the floor slightly in front of you.
                    Bend at the hips and knees to lower yourself, maintaining a neutral spine, and grasp the kettlebell with both hands.
                    Swing the kettlebell between your legs while keeping your back straight and hinging at the hips.
                    Explosively drive your hips forward, extending your hips and knees to propel the kettlebell up to chest level.
                    Let the kettlebell swing back between your legs, and repeat the motion in a fluid, controlled manner.
                    Ensure you maintain a strong core and use your hip power to swing the kettlebell, rather than relying on your arms. 
                    The kettlebell swing is an excellent exercise for building strength, power, and conditioning. Start with 3 sets of 10-15 
                    swings and gradually increase the weight as you become more comfortable with the movement.</p>
                    
                    <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Kettlebell Swings')">
                    <input type="button" value="see" class="ex-btn" id="seeGif3" ondblclick="unSee('showGif3')">

            </div>
            <div class="showGif3" class="exerbox" style="margin-bottom:10px ;">

            </div>
            <div id="exerciseFormKettlebell Swings" class="ex-form-des" style="display: none; margin: bottom 50px;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameKettlebell Swings">Add Exercise:</label>
                    <input type="text" id="exerciseNameKettlebell Swings" name="exerciseName" required><br><br>

                    <label for="exerciseDateKettlebell Swing">Date of Adding:</label>
                    <input type="date" id="exerciseDateKettlebell Swings" name="exerciseDate" required><br><br>
                    
                    <script>
                        document.getElementById('exerciseDateKettlebell Swings').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Kettlebell Swings')">Cancel</button>
                </form>
                </div>
            <br>
            </div>
            <div class="ex_card2">
                <h2>Battle Rope</h2>
                <p><p>Battle ropes are a versatile and effective full-body workout tool.</p>
                <ol>
                    <li>1. Anchor the ropes to a stable point, such as a pole or wall.</li>
                    <li>2. Stand facing the anchor point with one rope in each hand.</li>
                    <li>3. Keep your feet shoulder-width apart and knees slightly bent.</li>
                    <li>4. Begin swinging the ropes in a wave-like motion by alternately lifting and lowering your arms.</li>
                    <li>5. Engage your core and maintain an upright posture throughout the exercise.</li>
                    <li>6. Vary the intensity by adjusting the speed and amplitude of the waves.</li>
                </ol>
                <p>Battle ropes provide an excellent cardiovascular workout while engaging your upper body, core, and lower body muscles. You can use them for timed intervals or incorporate them into various workout routines.</p>
                <p>A typical battle rope workout can range from 15-30 minutes, depending on your fitness level and goals. It's an effective way to build strength, endurance, and improve overall fitness.</p></p>
                
                <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Battle Rope')">
                <input type="button" value="see" class="ex-btn" id="seeGif4" ondblclick="unSee('showGif4')">

                </div>
                <div class="showGif4" class="exerbox" style="margin-bottom:20px ;">

                </div>

                <div id="exerciseFormBattle Rope" class="ex-form-des" style="display: none; margin: bottom 50px;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameBattle Rope">Add Exercise:</label>
                    <input type="text" id="exerciseNameBattle Rope" name="exerciseName" required><br><br>

                    <label for="exerciseDateBattle Rope">Date of Adding:</label>
                    <input type="date" id="exerciseDateBattle Rope" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDateBattle Rope').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Battle Rope')">Cancel</button>
                </form>
                </div>

                <br>

                <h2>BENCH PRESS</h2>
                <p>The bench press is a classic strength training exercise that primarily targets the chest, shoulders, and triceps.
                    To perform it, lie on a flat bench with your feet flat on the floor, grip the barbell slightly wider than shoulder-width apart, 
                    and lower it to your chest while keeping your elbows at a 90-degree angle. Push the barbell back up to the starting position.</p>

                <p>For optimal results, perform 3-4 sets of 8-12 repetitions with a weight that challenges you while maintaining proper form. 
                    Ensure you have a spotter when lifting heavy weights to assist in case you need help.</p>
                    
                    <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Bench Press')">
                    <input type="button" value="see" class="ex-btn" id="seeGif5" ondblclick="unSee('showGif5')">

                </div>
                
            </div>
            <div class="showGif5" style="margin-bottom:10px ;">

            </div>

            <div id="exerciseFormBench Press" class="ex-form-des" style="display: none; margin: bottom 50px;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameBench Press">Add Exercise:</label>
                    <input type="text" id="exerciseNameBench Press" name="exerciseName" required><br><br>

                    <label for="exerciseDateKettlebell Swing">Date of Adding:</label>
                    <input type="date" id="exerciseDateBench Press"name="exerciseDate" required><br><br>
                    
                    <script>
                        document.getElementById('exerciseDateBench Press').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Bench Press')">Cancel</button>
                </form>
            </div>
            
        </div>
    </div>
    <hr style="margin-bottom:200px;">
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
    
//part 1
const showGifDiv = document.querySelector('.showGif');
const seeGif1Button = document.getElementById('seeGif1');

const gifPath = 'adv_img/gif11.gif';

seeGif1Button.addEventListener('click', function() {

    const gifImage = document.createElement('img');
    gifImage.src = gifPath;
    gifImage.alt = 'GIF Image';


    showGifDiv.innerHTML = '';

    showGifDiv.appendChild(gifImage);
});

const showGifDiv2 = document.querySelector('.showGif2');
const seeGif2Button = document.getElementById('seeGif2');

//part 2
const gifPath2 = 'adv_img/gif12.gif';

seeGif2Button.addEventListener('click', function() {
    const gifImage2 = document.createElement('img');
    gifImage2.src = gifPath2;
    gifImage2.alt = 'GIF Image';
    showGifDiv2.innerHTML = '';
    showGifDiv2.appendChild(gifImage2); 
});
//part 3 
const showGifDiv3 = document.querySelector('.showGif3');
const seeGif3Button = document.getElementById('seeGif3');

const gifPath3 = 'adv_img/gif13.gif'; 

seeGif3Button.addEventListener('click', function() {

    const gifImage3 = document.createElement('img');
    gifImage3.src = gifPath3;
    gifImage3.alt = 'GIF Image';

    showGifDiv3.innerHTML = '';

    showGifDiv3.appendChild(gifImage3);
});
//part 4
const showGifDiv4 = document.querySelector('.showGif4');
const seeGif4Button = document.getElementById('seeGif4');

const gifPath4 = 'adv_img/gif14.gif';

seeGif4Button.addEventListener('click', function() {

    const gifImage4 = document.createElement('img');
    gifImage4.src = gifPath4;
    gifImage4.alt = 'GIF Image';

    showGifDiv4.innerHTML = '';

    showGifDiv4.appendChild(gifImage4);
});

//part 5
const showGifDiv5 = document.querySelector('.showGif5');
const seeGif5Button = document.getElementById('seeGif5');

const gifPath5 = 'adv_img/gif15.gif';

seeGif5Button.addEventListener('click', function() {

    const gifImage5 = document.createElement('img');
    gifImage5.src = gifPath5;
    gifImage5.alt = 'GIF Image';

    showGifDiv5.innerHTML = '';

    showGifDiv5.appendChild(gifImage5);
});
function unSee(gifDivId) {
    const showGifDiv = document.querySelector(`.${gifDivId}`);
    showGifDiv.innerHTML = '';
}
function showExerciseForm(exerciseName) {
    const formId = `exerciseForm${exerciseName}`;
    const addExerciseForm = document.getElementById(formId);
    addExerciseForm.style.display = 'block';
}
//ex form
function showExerciseForm(exerciseName) {
    const formId = `exerciseForm${exerciseName}`;
    const addExerciseForm = document.getElementById(formId);
    const selectedExerciseName = exerciseName === '' ? ' ' : exerciseName;
    document.getElementById(`exerciseName${exerciseName}`).value = selectedExerciseName;

    addExerciseForm.style.display = 'block';
}
function cancelExercise(exerciseName) {
    const formId = `exerciseForm${exerciseName}`;
    const addExerciseForm = document.getElementById(formId);
    addExerciseForm.style.display = 'none';
}
</script>
</body>
</html>
