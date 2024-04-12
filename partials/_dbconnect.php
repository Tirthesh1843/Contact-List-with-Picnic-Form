<?php
$server="localhost";
$username ="root";
$password ="";
$database ="trip";

$conn = mysqli_connect($server, $username, $password, $database);
if ($conn){
 //echo "sucess";
}
else{
    die("Error". mysqli_connect_error ());
}
?>