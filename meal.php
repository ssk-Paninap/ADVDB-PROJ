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

    if ($row = mysqli_fetch_assoc($result)) {

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
if (isset($_SESSION['username'])) {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "work_it_out_proj";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $user_id = $_SESSION['Id'];

    $sql = "SELECT meal_name, meal_category, amount_of_protein, amount_of_carbs, id_meal FROM meals WHERE Id = $user_id";
    $result = $conn->query($sql);
    $conn->close();
    } else {
    header("Location: login.php");
    exit();
}
//var_dump($result,); //wag alisin
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Food List</title>
  <link rel="stylesheet" href="page_design.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid black;
    }
  </style>
</head>
<body>
  <div id="navbar">
    <nav>
      <label class="logo"><a href="home.php">WorkItOut</a></label>
      <ul>
        <li><a href="home.php" class="nav-active">Home</a></li>
        <li><a href="Categories.php" class="nav-active">Categories</a></li>
        <li><a href="CaloCal.php" class="nav-active">Calculator</a></li>
        <li><a href="meal.php" class="nav-active">Meals</a></li>
        <li><a href="about.html" class="nav-active">About</a></li>
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

<div id="meal-container" class="meal-container">
    <div class="meal-diving">
      <div id="meal-added-food-list-container" class="meal-added-food-list-container">
        <h2>FOOD LIST PREVIEW:<h5> (the value varies based on the amount you ate)</h5></h2>
        <table id="meal-added-food-list" class="meal-added-food-list">
          <tr>
            <th>Meal ID</th>
            <th>Meal Name</th>
            <th>Meal Category</th>
            <th>Amount of Protein</th>
            <th>Amount of Carbs</th>
          </tr>
         <tbody>
         <?php foreach ($result as $results): ?>
          <tr>
          <td><?php echo $results['id_meal']; ?></td>
          <td><?php echo $results['meal_name']; ?></td>
          <td><?php echo $results['meal_category']; ?></td>
          <td><?php echo $results['amount_of_protein']; ?></td>
          <td><?php echo $results['amount_of_carbs']; ?></td>
          </tr>
          <?php endforeach; ?>
         </tbody>
         </tbody>
        </table>
      </div>
    </div>

    <div class="meal-actions">
    <form method="post" action="delete_in_meal_page.php">
    <label for="id_meal">Enter Meal ID to Remove:</label>
    <input type="number" name="id_meal" placeholder="Enter Meal ID">
    <button type="submit" class="meal-clear" class="btn2-meal">Remove an Item</button>
  </form>
    </div>

          

  <form id="mealForm" method="post" action="save_meal.php">
      <input type="hidden" name="meal_name" id="meal_name">
      <input type="hidden" name="meal_category" id="meal_category">
      <input type="hidden" name="amount_of_protein" id="amount_of_protein">
      <input type="hidden" name="amount_of_carbs" id="amount_of_carbs">
        
        <div class="btn_holder_meal"> 
            <ul>
            <h3>High Carbs</h3>
              <li><button class="meal-add-button" onclick="addItem('Rice')">Rice</button></li>
              <li><button class="meal-add-button" onclick="addItem('Bread')">Bread</button></li>
              <li><button class="meal-add-button" onclick="addItem('Pasta')">Pasta</button></li>
              <li><button class="meal-add-button" onclick="addItem('Potatoes')">Potatoes</button></li>
            </ul>


            <ul>
            <h3>High Protein</h3>
              <li><button class="meal-add-button" onclick="addItem('Chicken')">Chicken</button></li>
              <li><button class="meal-add-button" onclick="addItem('Beef')">Beef</button></li>
              <li><button class="meal-add-button" onclick="addItem('Fish')">Fish</button></li>
              <li><button class="meal-add-button" onclick="addItem('Eggs')">Eggs</button></li>
            </ul>


            
            <ul>
            <h3>Dairy foods</h3>
              <li><button class="meal-add-button" onclick="addItem('Milk')">Milk</button></li>
              <li><button class="meal-add-button" onclick="addItem('Cheese')">Cheese</button></li>
              <li><button class="meal-add-button" onclick="addItem('Yogurt')">Yogurt</button></li>
              <li><button class="meal-add-button" onclick="addItem('Ice Cream')">Ice Cream</button></li>
            </ul>



            <ul>
            <h3>Fruits and Vegies</h3>
              <li><button class="meal-add-button" onclick="addItem('Apples')">Apples</button></li>
              <li><button class="meal-add-button" onclick="addItem('Bananas')">Bananas</button></li>
              <li><button class="meal-add-button" onclick="addItem('Oranges')">Oranges</button></li>
              <li><button class="meal-add-button" onclick="addItem('Carrots')">Carrots</button></li>
            </ul>

         </div>

    </form>
</div>
</div>
  <script>
    function addItem(food) {
      document.getElementById('meal_name').value = food;
      document.getElementById('meal_category').value = getCategory(food);
      document.getElementById('amount_of_protein').value = '';
      document.getElementById('amount_of_carbs').value = ''; 
      displayItemInTable(food);
    }

    function getCategory(food) {
      if (food === 'Rice' || food === 'Bread' || food === 'Pasta' || food === 'Potatoes') {
        return 'High Carbs';
      } else if (food === 'Chicken' || food === 'Beef' || food === 'Fish' || food === 'Eggs') {
        return 'High Protein';
      } else if (food === 'Milk' || food === 'Cheese' || food === 'Yogurt' || food === 'Ice Cream') {
        return 'Dairy';
      } else {
        return 'Fruits and Vegies';
      }
    }

    function displayItemInTable(food) {
      var table = document.getElementById('meal-added-food-list');
      var row = table.insertRow(-1);
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      var cell3 = row.insertCell(2);
      var cell4 = row.insertCell(3);
      cell1.innerHTML = food;
      cell2.innerHTML = getCategory(food);
      cell3.innerHTML = document.getElementById('amount_of_protein').value;
      cell4.innerHTML = document.getElementById('amount_of_carbs').value;
    }


  </script>
</body>
</html>
