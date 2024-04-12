<?php
$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'partials/_dbconnect.php';
  $username = $_POST["email"];
  $password = $_POST["password"];
  //$sql = "Select * from users where username= '$username' AND password='$password'";
  $sql = "select * from users where email= '$username' ";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row['password'])) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $username;
        $_SESSION['user_id'] =  $row['id'];
        header("location: index.php");
      } else {
        $showError = "credentials not match";
      }
    }
  } else {
    $showError = "credentials not match";
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css_files/login.css">
  <title>Login</title>
</head>

<body>
  <?php require 'partials/_nave.php'
  ?>
  <?php
  if ($login) {
    echo ' <div class="alert alert-sucess alert-dismissible fade show" role="alert">
        <strong>sucess</strong> you are logged in.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <span aria-hidden="true">&times;</span>
        </div> ';
  }
  if ($showError) {
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>error</strong> ' . $showError . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <span aria-hidden="true">&times;</span>
      </div> ';
  }
  ?>
  <div class="login-box">
    <h2>Login</h2>
    <form action="login.php" method="post">
      <div class="user-box">
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
        <label for="email"> Email</label>
      </div>
      <div class="user-box">
        <input type="Password" class="form-control" id="password" name="password">
        <label for="password">Password</label>
      </div>
      <a href="">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <button type="submit" class="button">login</button>
      </a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>