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
    <title>Beginner Workouts</title>
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
        <h1>Beginner Workouts that you can try...</h1>
        <div class="beginner_container">
            <div class="ex_card">
                <div class="slide active" class="item-1">
                    <p>Walking<span>Brisk walking involves maintaining a fast and purposeful pace, 
                        typically faster than a leisurely stroll but not as intense as running. 
                        This form of exercise provides numerous health benefits, including improved cardiovascular fitness, weight management, and stress reduction. 
                        To engage in brisk walking, one should focus on swinging their arms, taking longer strides, 
                        and maintaining a brisk but comfortable speed for an extended duration.</span></p>
                <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Walking')">
                <input type="button" value="see" class="ex-btn" id="seeGif1" ondblclick="unSee('showGif')">
                </div>
                <div class="showGif" class="exerbox" style="margin-bottom:10px ;">

                </div>

                <div id="exerciseFormWalking" class="ex-form-des" style="display: none;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameWalking">Exercise Name:</label>
                    <input type="text" id="exerciseNameWalking" name="exerciseName" readonly required>

                    <label for="exerciseDateWalking">Date of Adding:</label>
                    <input type="date" id="exerciseDateWalking" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDateWalking').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Walking')">Cancel</button>
                </form>
                </div>


                <br>

            <div class="slide" class="item-2">
                <p>Cycling <span>Cycling is an excellent form of exercise that offers a low-impact, 
                    full-body workout. It helps strengthen leg muscles, improve cardiovascular health,
                     and can be an effective way to burn calories and maintain a healthy weight. To cycle 
                     properly, ensure your bike is appropriately adjusted for your height, maintain proper
                      posture, keep a consistent cadence, and wear appropriate safety gear like a helmet. 
                      Start with shorter rides and gradually increase your distance and intensity as your 
                      fitness level improves.</span></p>
                       <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Cycling')">
                        <input type="button" value="see" class="ex-btn" id="seeGif2" ondblclick="unSee('showGif2')">
            </div>
            <div class="showGif2" class="exerbox" style="margin-bottom:50px;">

            </div>
            <div id="exerciseFormCycling" class="ex-form-des" style="display: none;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameCycling">Add Exercise:</label>
                    <input type="text" id="exerciseNameCycling" name="exerciseName" required><br><br>

                    <label for="exerciseDateCycling">Date of Adding:</label>
                    <input type="date" id="exerciseDateCycling" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDateCycling').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Cycling')">Cancel</button>
                </form>
            </div>
            <br>

            <div class="slide" class="item-3">
                <p>Push ups <span>To perform a proper push-up, begin in a plank position with your hands placed 
                    slightly wider than shoulder-width apart, fingers pointing forward, and your
                     body in a straight line from head to heels. Lower your body by bending your elbows until your 
                     chest nearly touches the ground while keeping your core engaged and back 
                     straight. Push back up to the starting position, fully extending your arms. 
                     Ensure that your elbows are tucked in, and your hips don't sag during the
                      exercise for the most effective and safe push-up.</span></p>
                      <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Push Ups')">
                        <input type="button" value="see" class="ex-btn" id="seeGif3" ondblclick="unSee('showGif3')">
            </div>
            <div class="showGif3" class="exerbox" style="margin-bottom:50px ;">

            </div>
            <div id="exerciseFormPush Ups" class="ex-form-des" style="display: none;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNamePush Ups">Add Exercise:</label>
                    <input type="text" id="exerciseNamePush Ups" name="exerciseName" required><br><br>

                    <label for="exerciseDatePushUps">Date of Adding:</label>
                    <input type="date" id="exerciseDatePush Ups" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDatePush Ups').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Push Ups')">Cancel</button>
                </form>
            </div>
            <br>
            </div>
            <div class="ex_card2">
                <div class="slide" class="item-4">
                    <p>Sit ups <span>To execute proper sit-ups, lie on your back with your knees bent, feet flat on the ground, 
                        and hands behind your head, but avoid interlocking your fingers. Engage your core muscles and lift your 
                        upper body off the ground by flexing at your waist, while keeping your neck and spine in a neutral position. 
                        Exhale as you rise and lower your upper body back to the ground with control, avoiding any jerking or straining 
                        of your neck, for an effective and safe sit-up.</span></p>
                    <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Sit Ups')">
                        <input type="button" value="see" class="ex-btn" id="seeGif4" ondblclick="unSee('showGif4')">
                </div>
                <div class="showGif4" class="exerbox" style="margin-bottom:50px ;">

                </div>
                <div id="exerciseFormSit Ups" class="ex-form-des" style="display: none;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNameSitUps">Add Exercise:</label>
                    <input type="text" id="exerciseNameSit Ups" name="exerciseName" required><br><br>

                    <label for="exerciseDateSitUps">Date of Adding:</label>
                    <input type="date" id="exerciseDateSit Ups" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDateSit Ups').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Sit Ups')">Cancel</button>
                </form>
            </div>
            <br>
                
                <div class="slide" class="item-5">
                    <p>Planking<span>To perform a proper plank, start in a push-up position with your forearms resting on the ground,
                        elbows directly under your shoulders, and your body forming a straight line from head to heels. Engage your core 
                        muscles and hold this position, ensuring your hips are neither too high nor sagging, and your neck is in a neutral
                        alignment. Maintain a steady breathing pattern and aim to hold the plank for as long as you can while keeping good
                        form to strengthen your core and stabilize your body.</span></p>
                    <input type="button" value="Add Exercise" class="ex-btn" onclick="showExerciseForm('Planking')">
                        <input type="button" value="see" class="ex-btn" id="seeGif5" ondblclick="unSee('showGif5')">
                </div>
                
            </div>
            <div class="showGif5" class="exerbox" style="margin-bottom:150px ;">

            </div>
            <div id="exerciseFormPlanking" class="ex-form-des" style="display: none;">
                <form method="post" action="save_exercise.php">
                    <label for="exerciseNamePlanking">Add Exercise:</label>
                    <input type="text" id="exerciseNamePlanking" name="exerciseName" required><br><br>

                    <label for="exerciseDatePlanking">Date of Adding:</label>
                    <input type="date" id="exerciseDatePlanking" name="exerciseDate" required><br><br>

                    <script>
                        document.getElementById('exerciseDatePlanking').valueAsDate = new Date();
                    </script>

                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelExercise('Planking')">Cancel</button>
                </form>
            </div>
            <hr style="margin-bottom:50px;"> 
        </div>
    </div>
    <footer>
        <div class="footer-content">
            <p>&copy; 2023 WorkItOut</p>
            <ul>
                <li><a href="">WORK</a></li>
                <li><a href="">IT</a></li>
                <li><a href="">OUT</a></li>
            </ul>
        </div>
    </footer>

<script>
    //part 1
    const showGifDiv = document.querySelector('.showGif');
    const seeGif1Button = document.getElementById('seeGif1');

    const gifPath = 'beg_img/gif1.gif';

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
    const gifPath2 = 'beg_img/gif2.gif';

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

    const gifPath3 = 'beg_img/gif3.gif'; 

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

    const gifPath4 = 'beg_img/gif4.gif';

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

    const gifPath5 = 'beg_img/gif5.gif';

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
    // form part 
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
