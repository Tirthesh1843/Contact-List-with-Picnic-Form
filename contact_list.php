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
  $new_phone = $_POST['new_phone'];
  $new_address = $_POST['new_address'];
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
    $query = "UPDATE contacts SET name ='$new_name' , email = '$new_email', phone = '$new_phone', address = '$new_address', image ='$update_filename' WHERE id = '$id'";
    $query_run = mysqli_query($conn,$query);
 }
  $limit = 10;
  require 'partials/_nave.php';
?>
    <?php
    $insert = false;
    if(isset($_POST['name'])){
        $user_id = $_SESSION['user_id'];
        $phone = $_POST['phone'];
        $sql = "SELECT * FROM `trip`.`contacts` WHERE phone='$phone' AND `user_id` = '$user_id' ";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        $showError = false;
        if($num == 0){
    
                  $name = $_POST['name'];
                  $email = $_POST['email'];
                  $phone = $_POST['phone'];
                  // $image = $_POST['image'];
                  $address = $_POST['address'];
                  $filename = $_FILES["image"]["name"];
                  $tempname = $_FILES["image"]["tmp_name"];
                  $folder = "images/.$filename";
                  move_uploaded_file($tempname, $folder);
                  $user_id = $_SESSION['user_id'];
                  $sql = "INSERT INTO `trip`.`contacts` (`name`, `user_id`,`email`, `phone`, `image`, `address`, `created_at`) VALUES ('$name', '$user_id','$email', '$phone', '$folder','$address', current_timestamp());";
                  // echo $sql;
                  // Execute the query
                  if($conn->query($sql) == true){
                      $insert = true;
                  }
                  else{
                      echo "ERROR: $sql <br> $conn->error";
                  }     
                         $conn->close();
                }        
      else{
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>alert:</strong> <p>The contact is alredy present in your contact list.</p>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>' ;
     }
    } 
    
    ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Contacts - <?php echo $_SESSION['email'];?> </title>
      <link href=""https://fonts.googleapis.com/css?family=Trirong" rel="stylesheet">
      <link rel="stylesheet" href="css_files/contacts.css">
  </head>
  <body>
    <?php
     $search = $_GET['search'];
    ?>
    <div class="container">
    <center><h1>Contact List</h1></center> 
        <div class="row">
          <div class="col-6">
            <span class="navbar-text"><a href="add_contact.php" class="hi"><button type = "submit"class="btn">Add new Contact</button></a>   </span>
        </div>
        <div class="col-6">
          <form action="contact_list.php" method="get" style="text-align:right">
            <input type="text" name="search" placeholder="name" value="<?php echo $search;?>">
            <input type ="submit" value="Search" class= "btn">
          </form>
        </div>
      </div>
  </div>
    <table class="container" >
        <thead>
            <tr>
                <th><h1>Id</h1></th>
                <th><h1>Name</h2></th>
                <th><h1>Email ID</h1></th>
                <th><h1>Phone No.</h1></th>
                <th><h1>Address</h1></th>
                <th><h1>Image</h1></th>
                <th><h1>Edit</h1></th>
                <th><h1>Delete</h1></th>
            </tr>
        </thead>
        <?php
                  $user_id = $_SESSION['user_id'];
                  $sql = "SELECT * FROM `trip`.`contacts` WHERE `user_id` = '$user_id' ";
                  $result = mysqli_query($conn, $sql);
                  $showError = false;
                  if(mysqli_num_rows($result)> 0){
                    $j=1;
                     $limit = 10; // Number of items to display at a time
                  $page = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page number
                  $start = ($page - 1) * $limit; // Calculate starting point for fetching items
                    $search = $_GET['search'];
                    $sql = "SELECT * FROM `trip`.`contacts` WHERE `name` LIKE '%$search%' AND `user_id` = '$user_id' LIMIT $start, $limit" ;
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    foreach($result as $row){
                 ?>
                 <tbody>
                    <tr>
                         <td><?php    echo $j;$j++;?></td>
                         <td><?php    echo $row ['name']; ?></td>
                         <td><?php    echo $row ['email']; ?></td>
                         <td><?php    echo $row ['phone']; ?></td>
                         <td><?php    echo $row ['address']; ?></td>
                         <td>
                          <img src =   "<?php   echo $row ['image']; ?>" width="100px"/>
                         </td>
                         <td>
                            <a href = "edit.php?id=<?php echo $row['id']?>" class = "btn">Edit</a>
                         </td>
                         <td>
                            <a href = "delete.php?id=<?php echo $row['id']?>" class = "btn" onclick = 'return checkdelete()'>Delete</a>
                         </td>
                    </tr>
                    </tbody>
                   <?php 
             }       
            }
              else{
                echo ' 
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>alert:</strong> <p>No records found as given name.</p>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  <span aria-hidden="true">&times;</span>
                </div> ';
              }
          }
                 else {
                  echo ' 
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>alert:</strong> <p>No contacts yet added please first insert some contacts.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <span aria-hidden="true">&times;</span>
                  </div> ';       
              }
                            // Pagination links
            $sql = "SELECT * FROM `trip`.`contacts` WHERE `name` LIKE '%$search%' AND `user_id` = '$user_id' " ;
            $result = $conn->query($sql);
            $row = $result->num_rows;
            $total_records =$row; 
            $total_pages = ceil($total_records / $limit);
            for ($i=1; $i<=$total_pages; $i++) {
              echo "<th><a href='?page=$i & search=$search'class = 'button'>$i</a></th>";  } 
            ?>      
    </table><br>
  </div> 
  <script>
    function checkdelete()
    {
      return confirm('Are you sure you want to delete this contact?');
    }
  </script>
  </body>
</html>