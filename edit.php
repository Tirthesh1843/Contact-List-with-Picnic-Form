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
    <title>Edit - <?php echo $_SESSION['email'];?> </title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css_files/style.css">
  </head>
    <body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <?php require 'partials/_nave.php'?>
    <?php
        $id = $_GET['id'];
        $query ="SELECT * FROM `trip`.`contacts` WHERE id='$id'";
        $query_run = mysqli_query($conn,$query);
        if(mysqli_num_rows($query_run) > 0){
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM `trip`.`contacts` WHERE `user_id` = '$user_id' and id='$id'";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                 if($num > 0){
            foreach($query_run as $now){
                ?>
                  <h1>Edit Contact</h1>
                    <form action="contact_list.php" method="post" enctype="multipart/form-data">
                    <div class="half left cf">
                      <input type = "hidden" name= "id" value="<?php echo $now ['id'];?>"/>
                            <input type="text" name="new_name" id="new_name" value="<?php echo $now ['name'];?>">
                            <input type="email" name="new_email" id="new_email" value="<?php echo $now ['email'];?>">
                            <input type="phone" name="new_phone" id="new_phone" value="<?php echo $now ['phone'];?>"pattern="[0-9]{10}">
                            <input type="file" name="image" id="image" >
                            <input type="hidden" name="image_old" value="<?php echo $now ['image'];?>">
                    </div>
                          <div class="half right cf">
                            <textarea name="new_address" id="new_address" cols="30" rows="5" placeholder="Enter your address" required="true"><?php echo $now ['address'];?></textarea>
                          </div>
                          <input type="submit"  name="edit" id="input-submit" value ="edit">
                    </form>
                <?php
                  }  
                }
                else
                {
                  echo ' 
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>alert:</strong> <p>this contact does not belong to you.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <span aria-hidden="true">&times;</span>
                </div> ';
                }
        }
        else{
          echo "no records available" ;
        }
     ?>
  </body>
</html>