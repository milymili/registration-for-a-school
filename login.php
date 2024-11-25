<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
    <h1 style="text-align:center">Login to Continue</h1>
<form class="w3-container" action="control.php" method="post">
  <p>
  <label>Username</label>
  <input class="w3-input" type="text" name="uname"></p>
  <p>
  <label>Password</label>
  <input class="w3-input" type="password" name="pwd"></p>
  <p>
  <input class="w3-btn w3-black" type="submit" name="login_button" value="Login">
  </p>
</form>
</body>
</html>