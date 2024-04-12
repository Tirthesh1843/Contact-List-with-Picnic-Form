<?php
$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST" )
{
    include 'partials/_dbconnect.php';
    $username = $_POST ["email"];
    $password = $_POST ["password"];
    $cpassword = $_POST ["cpassword"];
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    //$exists =false;
    $existSql = "SELECT * FROM `users` WHERE email ='$username'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows ($result);
    if($numExistRows > 0){
    // $exist = true;
        $showError = "Email id alredy exist, try a different Email id.";
    }
    elseif(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        $showError =" Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
    }
    else{
    // $exist = false;
        if(($password == $cpassword)){
            $hash = password_hash($password , PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`email`, `password`, `created_at`) VALUES ('$username', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
                if($result){
                        $showAlert = true;
                    }
            }
            else{
                $showError = "passwords do not match.";
            } 
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
        <title>Sign up</title> 
    </head>
    <body>
    <?php require 'partials/_nave.php';
    if($showAlert){
     echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>sucess</strong> Your account is now created. you can login now.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <span aria-hidden="true">&times;</span>
    </div> ';
    }
    if($showError){
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
           <strong>error:</strong> '.$showError.'
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           <span aria-hidden="true">&times;</span>
           </div> ';
       }
    ?>
        <div class="login-box">
            <h2>sign up</h2>
            <form action="signup.php" method="post">
                <div class="user-box">
                <input type="email" maxlength="30" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                <label for="email"> Email</label>
                </div>
                <div class="user-box">
                <input type="password" maxlength="25" class="form-control" id="password" name="password">
                <label for="password">Password</label>
                </div>
                <div class="user-box">
                <input type="password" maxlength="25" class="form-control" id="cpassword" name="cpassword">
                <label for="cpassword">Confirm Password</label>
                </div>
                <a href="">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <button type="submit" class="button">Sign Up</button>
                </a>
            </form>
        </div>
    </body>
</html>