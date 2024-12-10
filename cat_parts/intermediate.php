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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intermediate Workouts</title>
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
        <h1>Intermediate Workouts that you can try...</h1>
        <div class="beginner_container">
            <div class="ex_card">
                <div class="slide active" class="item-1">
                    <h3>Jump Rope</h3>
                    <p>Jump roping is a highly effective cardiovascular exercise that involves repeatedly 
                        jumping over a rope as it passes under your feet. To execute a proper jump rope technique, start 
                        by standing with your feet together and the rope behind you. As you swing the rope over your head, 
                        jump off the ground using a coordinated motion, ensuring the rope clears your body and lands beneath
                         your feet. Maintain a consistent rhythm and land softly on the balls of your feet to minimize impact
                          and maximize efficiency in your jump roping workout.</p>
                <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Jump Rope')">
                <input type="button" value="see" class="ex-btn" id="seeGif1" ondblclick="unSee('showGif')">  
                </div>
                <div class="showGif" class="exerbox" style="margin-bottom:50px ;">

                </div>
                <div id="exerciseFormJump Rope" class="ex-form-des" style="display: none;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameJump Rope">Add Exercise:</label>
                    <input type="text" id="exerciseNameJump Rope" name="exerciseName" required><br><br>

                    <label for="exerciseDateJumpRope">Date of Adding:</label>
                    <input type="date" id="exerciseDateJump Rope" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDateJump Rope').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Jump Rope')">Cancel</button>
                </form>
                </div>
            </div>
                <br>

            <div class="slide" class="item-2">
                <h3>Jump Squats</h3>
                <p>Jump squats are a dynamic lower-body exercise that combines a traditional squat with an 
                    explosive jump. To execute jump squats properly, begin in a standing position with your feet shoulder-width 
                    apart. Lower your body into a squat by bending at the hips and knees, ensuring your knees do not go past your 
                    toes, then explosively push through your heels to jump as high as you can while extending your arms overhead. 
                    Upon landing, immediately go into the next squat, maintaining a fluid and controlled motion for a challenging 
                    plyometric workout.</p>
                      <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Jump Squats')">
                     <input type="button" value="see" class="ex-btn" id="seeGif2" ondblclick="unSee('showGif2')">
            </div>
            <div class="showGif2" class="exerbox" style="margin-bottom:50px ;">

            </div>
            <div id="exerciseFormJump Squats" class="ex-form-des" style="display: none;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameJump Squats">Add Exercise:</label>
                    <input type="text" id="exerciseNameJump Squats" name="exerciseName" required><br><br>

                    <label for="exerciseDateJumpSquats">Date of Adding:</label>
                    <input type="date" id="exerciseDateJump Squats" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDateJump Squats').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Jump Squats')">Cancel</button>
                </form>
                </div>

            <br>

            <div class="slide" class="item-3">
                <h3>Hammer Curls</h3>
                <p>Hammer curls are a variation of traditional bicep curls in which you hold a dumbbell in each hand with your palms facing your torso, in a neutral or "hammer" grip. To perform hammer curls, you bend your elbows while keeping your upper arms stationary, lifting the weights towards your shoulders. This exercise works not only the biceps but also targets the brachialis muscle and can be performed for a similar duration as standard bicep curls, typically within a range of 3 to 4 sets of 8-12 repetitions for optimal results.</p>
                       <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Hammer Curls')">
                    <input type="button" value="see" class="ex-btn" id="seeGif3" ondblclick="unSee('showGif3')">
            </div>
            <div class="showGif3" class="exerbox" style="margin-bottom:50px ;">

            </div>
            <div id="exerciseFormHammer Curls" class="ex-form-des" style="display: none;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameHammer Curls">Add Exercise:</label>
                    <input type="text" id="exerciseNameHammer Curls" name="exerciseName" required><br><br>

                    <label for="exerciseDateHammerCurls">Date of Adding:</label>
                    <input type="date" id="exerciseDateHammer Curls" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDateHammer Curls').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Hammer Curls')">Cancel</button>
                </form>
                </div>

            <br>

            </div>
            <div class="ex_card2">
                <div class="slide" class="item-4">
                    <h3>Lat pulldowns</h3>
                    <p>Lat pulldowns are an effective exercise for targeting the muscles in your upper back, particularly
                         the latissimus dorsi. To execute them correctly, sit down at a lat pulldown machine, securing your legs under the pads 
                         and grabbing the wide bar with an overhand grip that is wider than shoulder-width apart. Pull the bar down to your chest 
                         while keeping your back straight, and then slowly return it to the starting position while maintaining control throughout 
                         the movement.</p>
                    <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Lat Pulldowns')">
                <input type="button" value="see" class="ex-btn" id="seeGif4" ondblclick="unSee('showGif4')">
                </div>
                <div class="showGif4" class="exerbox" style="margin-bottom:50px ;">

                </div>
                <div id="exerciseFormLat Pulldowns" class="ex-form-des" style="display: none;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameLat Pulldowns">Add Exercise:</label>
                    <input type="text" id="exerciseNameLat Pulldowns" name="exerciseName" required><br><br>

                    <label for="exerciseDateLat Pulldowns">Date of Adding:</label>
                    <input type="date" id="exerciseDateLat Pulldowns" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDateLat Pulldowns').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Lat Pulldowns')">Cancel</button>
                </form>
                </div>


                <br>
                <div class="slide" class="item-5">
                    <h3>Dumbbell Lunges</h3>
                    <p>Dumbbell lunges are a compound lower-body exercise that works your quadriceps, hamstrings, and glutes. 
                        To perform them correctly, start by holding a dumbbell in each hand at your sides, with your feet together. Take a step forward 
                        with one leg, lowering your body until both knees are bent at a 90-degree angle, then push through your front heel to return 
                        to the starting position. Alternate legs for each repetition, ensuring proper balance and form throughout the exercise.</p>
                     <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Dumbbell Lunges')">
                    <input type="button" value="see" class="ex-btn" id="seeGif5" ondblclick="unSee('showGif5')">

                </div>
                
            </div>
            <div class="showGif5" style="margin-bottom:150px ;margin-top:25px;">

            </div>

            <div id="exerciseFormDumbbell Lunges" class="ex-form-des" style="display: none; margin: bottom 50px;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameDumbbell Lunges">Add Exercise:</label>
                    <input type="text" id="exerciseNameDumbbell Lunges" name="exerciseName" required><br><br>

                    <label for="exerciseDateDumbbell Lunges">Date of Adding:</label>
                    <input type="date" id="exerciseDateDumbbell Lunges" name="exerciseDate" required><br><br>
                    <script>
                        document.getElementById('exerciseDateDumbbell Lunges').valueAsDate = new Date();
                    </script>
                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Dumbbell Lunges')">Cancel</button>
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
<script lang="javascript">
//part 1
const showGifDiv = document.querySelector('.showGif');
const seeGif1Button = document.getElementById('seeGif1');

const gifPath = 'inter_img/gif6.gif';

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
const gifPath2 = 'inter_img/gif7.gif';

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

const gifPath3 = 'inter_img/gif8.gif'; 

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

const gifPath4 = 'inter_img/gif9.gif';

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

const gifPath5 = 'inter_img/gif10.gif';

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

//ex form
function showExerciseForm(exerciseName) {
    const formId = `exerciseForm${exerciseName}`;
    const addExerciseForm = document.getElementById(formId);

    const selectedExerciseName = exerciseName === 'Walking' ? 'Brisk Walking' : exerciseName;
    document.getElementById(`exerciseName${exerciseName}`).value = selectedExerciseName;

    addExerciseForm.style.display = 'block';
}

function cancelExercise(exerciseName) {
    // Reset the form and hide it
    const formId = `exerciseForm${exerciseName}`;
    const addExerciseForm = document.getElementById(formId);
    addExerciseForm.style.display = 'none';
}
</script>
</body>
</html>
