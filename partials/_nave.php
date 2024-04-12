<?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']== true){
  $loggedin= true;
}
else{
  $loggedin=false;
}
include 'partials/_dbconnect.php';
echo '
<style>
img {
  border-radius: 50%;
}
</style>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/loginsystem">    <img src="nav.png" width="50" height="50"> </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home<span class="sr-only"></span></a>
        </li>';
        if(!$loggedin){
        echo'<li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
          <li class="nav-item">
          <a class="nav-link" href="signup.php">Signup</a>
        </li>'
;}
        if($loggedin){
        echo'
        <li class="nav-item">
        <a class="nav-link" href="contact_list.php">Contacts</a>
        </li>
        ';
echo '</ul >
    </div>
  </div>';
    $id = $_SESSION['user_id'];
    $sql = "SELECT * FROM `trip`.`users` WHERE `id` = '$id' ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)> 0){
        foreach($result as $row){
          ?><span>
          Hello,</span>
          <?php
          if($row['name'] == ""){
            echo'<span>
            User
            </span>';
          }
          else{?>
          <span>
            <?php echo $row ['name'];?>
          </span>
          <?php
          }
          if($row['profile_picture'] == ""){
            ?>
            <span class="navbar-text">
          <a class="nav-link" href="profile.php" >
            <img src ="images/def_pp.jpg" alt="Avatar" style="width:100px"/>
          </a>  
        </span>
          <?php }
          else{
            ?>
          <span class="navbar-text">
          <a class="nav-link" href="profile.php" >
            <img src =   "<?php   echo $row ['profile_picture']; ?>"alt="Avatar" style="width:100px"/>
          </a>  
        </span>
         <?php }
          echo' 
   <span class="navbar-text">
    <a class="nav-link" href="logout.php" > Logout</a>
  </span>'
;
  }}}
echo'
</nav>';
?>