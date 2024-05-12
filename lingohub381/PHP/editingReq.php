<?php
DEFINE ("servername","localhost");
DEFINE ("username","root");
DEFINE ("password","");
DEFINE("dbname","lingohub");
if (!$connection=mysqli_connect(servername,username,password)) 
    die("Connection failed: " . mysqli_connect_error());

if(!$database= mysqli_select_db($connection, dbname))
   die("Could not Open the " . dbname ."database" );

   if(isset($_POST['edit_submit'])) {
   
$language =isset( $_POST['language']) && $_POST['language'] !== "" ? $_POST['language'] : $row['language'];
$proficiency = isset($_POST['proficiency']) && $_POST['proficiency'] !== "" ? $_POST['proficiency'] : $row['proficiency'];
$schedule = isset($_POST['schedule']) && $_POST['schedule'] !== "" ? $_POST['schedule'] : $row['schedule'];
$sessionDuration = isset($_POST['Session_duration']) && $_POST['Session_duration'] !== "" ? $_POST['Session_duration'] : $row['Session_duration'];
$comments = isset($_POST['comments']) && $_POST['comments'] !== "" ? $_POST['comments'] : $row['comments'];
          // Updating variables with form data or existing data if form data is not provided
      }
  
      // Update query
      $sql = "UPDATE `request` SET `LanguageName`='$language', `level`='$proficiency', `preferredSchedule`='$schedule', `sessionDuration`='$sessionDuration', `comment`='$comments' WHERE `RequestID`='1'";
      $res = mysqli_query($connection, $sql);
      if ($res) {
        // If update is successful, redirect to the page where you display learner requests
        header("Location: learnerReq.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
?>

<?php session_start();?>
<?php
DEFINE ("servername","localhost");
DEFINE ("username","root");
DEFINE ("password","");
DEFINE("dbname","lingohub");
if (!$connection=mysqli_connect(servername,username,password)) 
    die("Connection failed: " . mysqli_connect_error());

if(!$database= mysqli_select_db($connection, dbname))
   die("Could not Open the " . dbname ."database" );

   if(isset($_POST['edit_submit'])) {
   


$language =isset( $_POST['language']) && $_POST['language'] !== "" ? $_POST['language'] : $row['language'];
$proficiency = isset($_POST['proficiency']) && $_POST['proficiency'] !== "" ? $_POST['proficiency'] : $row['proficiency'];
$schedule = isset($_POST['schedule']) && $_POST['schedule'] !== "" ? $_POST['schedule'] : $row['schedule'];
$sessionDuration = isset($_POST['Session_duration']) && $_POST['Session_duration'] !== "" ? $_POST['Session_duration'] : $row['Session_duration'];
$comments = isset($_POST['comments']) && $_POST['comments'] !== "" ? $_POST['comments'] : $row['comments'];
          // Updating variables with form data or existing data if form data is not provided
      
  
      // Update query
      $sql = "UPDATE `request` SET `LanguageName`='$language', `level`='$proficiency', `preferredSchedule`='$schedule', `sessionDuration`='$sessionDuration', `comment`='$comments' WHERE `RequestID`='1'";
      $res = mysqli_query($connection, $sql);
      if ($res) {
        // If update is successful, redirect to the page where you display learner requests
        header("Location: learnerReq.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}
?>
 <?php 
    if(isset($_GET['edit_submit'])) {
   
        $language =isset( $_GET['language']) && $_GET['language'] !== "" ? $_GET['language'] : $row['language'];
        $proficiency = isset($_GET['proficiency']) && $_GET['proficiency'] !== "" ? $_GET['proficiency'] : $row['proficiency'];
        $schedule = isset($_GET['schedule']) && $_GET['schedule'] !== "" ? $_GET['schedule'] : $row['schedule'];
        $sessionDuration = isset($_GET['Session_duration']) && $_GET['Session_duration'] !== "" ? $_GET['Session_duration'] : $row['Session_duration'];
        $comments = isset($_GET['comments']) && $_GET['comments'] !== "" ? $_GET['comments'] : $row['comments'];
        //           // Updating variables with form data or existing data if form data is not provided
              
          
              // Update query
              $sql = "UPDATE `request` SET `LanguageName`='$language', `level`='$proficiency', `preferredSchedule`='$schedule', `sessionDuration`='$sessionDuration', `comment`='$comments'WHERE `RequestID` = '" . $ID. "'";
              $res = mysqli_query($connection, $sql);
              if ($res) {
                // If update is successful, redirect to the page where you display learner requests
                echo "updated";
            } else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
 ?>