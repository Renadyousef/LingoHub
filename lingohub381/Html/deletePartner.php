<!DOCTYPE html>
<?php session_start(); ?>
<?php
DEFINE ("servername","localhost");
DEFINE ("username","root");
DEFINE ("password","");
DEFINE("dbname","lingohub");
if (!$connection=mysqli_connect(servername, username, password)) 
    die("Connection failed: " . mysqli_connect_error());

    
if(!$database = mysqli_select_db($connection, dbname))
   die("Could not Open the " . dbname ."database" );
   if(isset($_POST['delete_request'])) {
   if($_POST['pass'] === $_SESSION['password']) {
    // Passwords match, proceed with deletion
    $ID = $_POST['ID'];
    
    // Your database connection code
    
    $delete_query = "DELETE FROM `partner` WHERE `partnerID` = '$ID'";
    $delete_result = mysqli_query($connection, $delete_query);
    
    if($delete_result) {
        echo "<script>alert('Deleted successfully');</script>";
        header("Location: learnerReq.php");
        exit();
    } else {
        echo "Error deleting request: " . mysqli_error($connection);
    }
} else {
   
    $error_message = "Incorrect password. Please try again.";
}

}
mysqli_close($connection);
?>

<html>

<head>

        <meta charset="UTF-8">
        <title>Delete Profile</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="../css/styles.css" type="text/css" rel="stylesheet">

</head>

<body id = "ProfileManage">
    <?php include("LearnerHeaderFooter.php");
     $ID = isset($_GET['ID']) ? $_GET['ID'] : (isset($_POST['ID']) ? $_POST['ID'] : null);
    ?>

    <div class ="ManageProfileBody" >
        <div class="right">
                       
            <h3>delete  Profile</h3>
            <img src="Delete-Icon.png"  id="deletepic" alt="delete">  
            <h4 id="delet_acc">Please enter your password to delete your Account:</h4>
            <h5 id="delet_acc">This action will delete your Account</h5>
            <?php if(isset($error_message)) { ?>
                    <div id="delet_acc" style="color:red;"><?php echo $error_message; ?></div>
                <?php } ?>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                 <input type="password" name="pass" placeholder="Enter new password" id="password_deleteaccount"> 
                <br><br><br><br><br><br>
                <div class="button-container2">
                    <button class="reject" type="submit" name="delete_request" >Delete</button>
                    <button class="contact" onclick="window.location.href='reqDetails.php'">Cancel</button>
                </div>
            </form>
            <!--<ul id="delete">
                <li id="reedButton"><a href = "homepage.html"><input  id="reedButton" type="submit" value="Delete "></a></li>
                <li > <a href = "learner-profile.html">Cancel</a></li>
             </ul> -->
    </div>
   


    </div>

        
</body>

  </html>



