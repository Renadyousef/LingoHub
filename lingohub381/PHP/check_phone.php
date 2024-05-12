<?php
DEFINE ("servername","localhost");
DEFINE ("username","root");
DEFINE ("password","");
DEFINE("dbname","lingohub");
if (!$connection=mysqli_connect(servername,username,password)) 
    die("Connection failed: " . mysqli_connect_error());

if(!$database= mysqli_select_db($connection, dbname))
   die("Could not Open the " . dbname ."database" );
$phone = $_POST['phone'];
$sql = "SELECT phone FROM `learner` WHERE phone = '$phone'";
$result = mysqli_query($connection, $sql);
$numRows = mysqli_num_rows($result);
if ($numRows > 0) {
    echo "exists";
} else {
    echo "not_exists";
}
?>