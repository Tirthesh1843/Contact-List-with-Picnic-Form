<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}
include 'partials/_dbconnect.php';
?>
<?php
$insert = false;
if (isset($_POST['name'])) {
  $user_id = $_SESSION['user_id'];
  $name = $_POST['name'];
  $gender = $_POST['gender'];
  $age = $_POST['age'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $desc = $_POST['desc'];
  $sql = "INSERT INTO `trip`.`trip` (`name`,`user_id` ,`age`, `gender`, `email`, `phone`, `other`, `dt`) VALUES ('$name', '$user_id','$age', '$gender', '$email', '$phone', '$desc', current_timestamp());";
  // echo $sql;
  // Execute the query
  if ($conn->query($sql) == true) {

    $insert = true;
  } else {
    echo "ERROR: $sql <br> $conn->error";
  }
  $conn->close();
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
  <link rel="stylesheet" href="css_files/style.css">
  <title>Trip Form-<?php echo $_SESSION['email']; ?></title>
</head>

<body>
  <?php require 'partials/_nave.php' ?>
  <h1>Trip to science city With GECM</h1>
  <?php
  if ($insert == true) {
    echo "<center><p class='input-data' style = '  color : #0dff00 '>Thanks for submitting your form. We are happy to see you joining us for the trip</p></center>";
  }
  ?>
  <form class="cf" action="index.php" method="post">
    <div class="half left cf">
      <input type="text" name="name" id="name" placeholder="Enter your Name" required>
      <input type="email" name="email" id="email" placeholder="Enter your Email" required>
      <input type="phone" name="phone" id="phone" placeholder="Enter your Number" required><br>
      <label for="gender" name="gender" id="gender">Select your Gender<select name="gender"></n>
          <option value="female">Female</option>
          <option value="male">Male</option>
          <option value="other">Other</option>
          <option value="Prefer not to answer">Perfer not to Answer</option>
        </select></label>
    </div>
    <div class="half right cf">
      <input type="NUMBER" name="age" id="age" placeholder="Enter your Age" required>
      <textarea name="desc" id="desc" cols="30" rows="5" placeholder="Enter your Address"></textarea>
    </div>
    <input type="submit" id="input-submit" value="Submit">
  </form>
</body>

</html>