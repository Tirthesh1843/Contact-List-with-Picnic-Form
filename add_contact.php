<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!= true){
    header("location: login.php");
    exit;
}
if(isset($_POST['name'])){}
include 'partials/_dbconnect.php';
?>
<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add contacts - <?php echo $_SESSION['email'];?> </title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css_files/style.css">
  </head>
  <body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <?php require 'partials/_nave.php'?>
    <h1>Add new Contact</h1>
    <form class="cf" action="contact_list.php" method="post" enctype="multipart/form-data">
      <div class="half left cf">
          <input type = "hidden" name= "id" value="<?php echo $now ['id'];?>"/>
          <input type="text" name="name" id="name" placeholder="Enter your name" required="true">
          <input type="email" name="email" id="email" placeholder="Enter your email" required="true">
          <input type="phone" name="phone" id="phone" placeholder="Enter your phone" required="true" pattern="[0-9]{10}">
          <input type="file" name="image" id="image"  required="true">
      </div>
      <div class="half right cf">
          <textarea name="address" id="address" cols="30" rows="5" placeholder="Enter your address" required="true"></textarea>
      </div>  
          <input type="submit" name="submit" id="input-submit" value ="add">
    </form>
  </body>
</html>