<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Let's work it out!!</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="center">
      <h2>Sign up to WORK IT OUT!</h2>
      <form method="post" action="connect.php">

        <div class="txt_field">
          <input type="text" required name="username">
          <span></span>
          <label>Username:</label>
        </div>
        
        <div class="txt_field">
          <input type="text" required name="email">
          <span></span>
          <label>Email:</label>
        </div>

        <div class="txt_field">
          <input type="password" name="password" required>
          <span></span>
          <label>Password:</label>
        </div>

        </label>

        <div class="txt_field">
          <input type="text" required name="age">
          <span></span>
          <label>Age:</label>
        </div>

        <div class="txt_field">
          <input name= "starting_weight" type="text" required>
          <span></span>
          <label>Starting Weight:</label>
        </div>

        <div class="txt_field">
          <input name= "starting_height" type="text" required>
          <span></span>
          <label>Starting Height:</label>
        </div>

        <div id="gender-container">
          <h4>Gender:</h4>
          <input type="radio" id="male" name="gender" value="male">
          <label for="male">Male</label>

          <input type="radio" id="female" name="gender" value="female">
          <label for="female">Female</label>

          <input type="radio" id="other" name="gender" value="other">
          <label for="other">Others:</label>

        <input type="submit" value="Sign up">
      <div class="signup_link">
        Sign Up and create your account today<a href="#"></a>
      </div>

    </form>
      </form>
    </div>
  </body>
</html>
