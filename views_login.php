<?php
session_start();

// If the user is already logged in, redirect them to another page
if(isset($_SESSION['user'])) {
   header("Location: dashboard.php");
   exit;
}

// Handle the login form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Perform login validation and authentication here
   // ...
   
   // If the login is successful, set the user session variable and redirect to dashboard
   $_SESSION['user'] = $username;
   header("Location: dashboard.php");
   exit;
}
?>

<!DOCTYPE html>
<html>
<head>
   <title>Login</title>
</head>
<body>
   <h1>Login</h1>
   
   <!-- Login form -->
   <form method="POST" action="views_login.php">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required>
      <br>
      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>
      <br>
      <input type="submit" value="Login">
   </form>
</body>
</html>