<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!= true){
    header("location: login.php");
    exit;
}
if(isset($_POST['name'])){}
?>
<?php
include 'partials/_dbconnect.php';?>
<?php
if(isset($_POST['edit']))
{
  $id = $_POST['id'];
  $new_name = $_POST['new_name'];
  $new_email = $_POST['new_email'];
  $temp_name = $_FILES["image"]["tmp_name"];
  $new_image = $_FILES["image"]["name"];
  $old_image = $_POST['image_old'];
  if($new_image != ''){
    $update_filename =  "images/.$new_image";
    move_uploaded_file($temp_name, $update_filename);
  }
  else{
    $update_filename = $old_image;
  }
  if(file_exists("images/".$_FILES["image"]["tmp_name"])){
    $filename = $_FILES["image"]["tmp_name"];
    $_SESSION['status'] = "image alredy exists".$filename;
  }
    $query = "UPDATE users SET name ='$new_name' , email = '$new_email', profile_picture ='$update_filename' WHERE id = '$id'";
    $query_run = mysqli_query($conn,$query);
 }
 ?>
<!doctype html>
<html lang="en">
  <head>
    <title>Profile-<?php echo $_SESSION['email'];?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css_files/profile.css">  
          <style>
      img {
        border-radius: 50%;
      }
      </style>
    </head>
  <body>
  <?php require 'partials/_nave.php'?>
  <?php
                $email = $_SESSION['email'];
                $id = $_SESSION['user_id'];
                $sql = "SELECT * FROM `trip`.`users` WHERE `id` = '$id' ";
                $result = mysqli_query($conn, $sql);
                $showError = false;
                if(mysqli_num_rows($result)> 0){
                    foreach($result as $row){
                 ?>
                 <h1>Edit user Profile</h1>
                 <br><br>
  <table class="container"style="width:25%" >
        <thead>
            <tr>
                <th rowspan="2" colspan="2">
                  <center>
                    <img src =   "<?php   echo $row ['profile_picture']; ?>"alt="Avatar" style="width:250px"/>
                  </center>
                </th>
              </tr>
        </thead>
        <thead>
        <tr>
          <th>              </th>
        </tr>
        </thead>
                      
                 <tbody>
                    <tr>
                        <td><center>Name:</center></td>
                        <td><?php    echo $row ['name']; ?></td>
                    </tr>
                    <tr>
                        <td><center>Email Id:</center></td>
                        <td><?php    echo $row ['email']; ?></td>
                    </tr>
                    <th rowspan="2" colspan="2">
                      <br><center> <a href = "edit_profile.php?id=<?php echo $row['id']?>" class = "btn">Edit</a></center>
                    </th> 
                    </tbody>
                    <?php
                  }}
                    ?>
                </body>
</html>