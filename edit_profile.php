<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!= true){
    header("location: login.php");
    exit;
}
?>
<?php
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
    <title>Edit_Profile-<?php echo $_SESSION['email'];?> </title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css_files/style.css">
  </head>
  <body>
  <?php require 'partials/_nave.php'?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <?php         
  $email = $_SESSION['email'];
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM `trip`.`users` WHERE `email` = '$email' and id='$user_id'";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                $showError = false;
                if($num > 0){
                  foreach($result as $now){         
                ?>
                  <h1>Edit user Profile</h1>
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                    <div class="half left cf">
                      <input type = "hidden" name= "id" value="<?php echo $now ['id'];?>"/>
                            <input type="text" name="new_name" id="new_name" value="<?php echo $now ['name'];?>">
                            <input type="email" name="new_email" id="new_email" value="<?php echo $now ['email'];?>">
                            <input type="file" name="image" id="image" >
                            <input type="hidden" name="image_old" value="<?php echo $now ['profile_picture'];?>">
                    </div>
                            <input type="submit"  name="edit" id="input-submit" value ="edit">
                    </form>
                <?php
                  }  
                }
                else
                {
                  echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>alert:</strong> <p>this email does not belong to you.</p>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  <span aria-hidden="true">&times;</span>
               </div> ';
                }
     ?>
  </body>
</html>