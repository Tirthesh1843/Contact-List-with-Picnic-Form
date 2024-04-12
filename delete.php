<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
if (isset($_POST['name'])) {
}
?>
<?php
include 'partials/_dbconnect.php';
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM `trip`.`contacts` WHERE `user_id` = '$user_id' ";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
$showError = false;
if ($num > 0) {
    foreach ($result as $yet) {
?>
        <?php
        $id = $_GET['id'];
        $sql = "DELETE FROM contacts WHERE id = '$id'";
        $run = mysqli_query($conn, $sql);
        if ($run) {
            echo "data deleted";
            header("location: contact_list.php");
        ?>
            <html>

            <body>
                <title><?php echo $_SESSION['username'] ?></title>
    <?php
        } else {
            echo "data deletion failed";
        }
    }
} else {
    echo ' 
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>alert:</strong> <p>this contact does not belong to you.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <span aria-hidden="true">&times;</span>
            </div> ';
}
    ?>
            </body>

            </html>