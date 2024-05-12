
<?php
session_start();
DEFINE ("servername","localhost");
DEFINE ("username","root");
DEFINE ("password","");
DEFINE("dbname","lingohub");
if (!$connection=mysqli_connect(servername,username,password)) 
    die("Connection failed: " . mysqli_connect_error());

if(!$database= mysqli_select_db($connection, dbname))
   die("Could not Open the " . dbname ."database" );

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>My Profile</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="../css/styles.css" type="text/css" rel="stylesheet">

</head>

<body id = "ProfileManage">
<?php include("LearnerHeaderFooter.php"); ?>

 <div class ="ManageProfileBody" >
 <?php
   $sql = "SELECT * FROM `learner` WHERE learnerID ='" . $_SESSION["ID"] . "'";
   $resuslt = mysqli_query($connection,$sql);
   if($resuslt){
      if(mysqli_num_rows($resuslt)>0){
          while($row = mysqli_fetch_array($resuslt)){
?>

        <div class="left">
            <img  src="<?php echo $row['photo']; ?>" id="img" alt="Personal photo">   
            
        </div>

        <div class="right">
                       
                        <h3>MY Profile</h3>
                     <div class="info_data">
                        <div class="data">
                            <h4>First name</h4> 
                            <p><?php echo $row['firstName']; ?></p>
                            <h4>Email</h4> 
                            <p><?php echo $row['email']; ?></p>
                            <h4>city</h4> 
                            <p><?php echo $row['city']; ?></p>
                        
                         </div>
                         <div class="data">
                            <h4>Last name</h4>
                            <p><?php echo $row['lastName']; ?></p>
                            <h4>Location</h4> 
                            <p><?php echo $row['location']; ?></p>
                         </div>

                           

                    </div>
                    <br><br><br><br><br><br>
                    <div class="button-container2">
                        <button class="accept" onclick="window.location.href='learner-Editeprofile.php'">Edit profile</button>
                        <button class="reject" onclick="window.location.href='learner-deleteProfile.php'">Delete profile</button>
                    </div>
                    
         </div>
         <!--End of class "right" -->

 </div><!--End of class "ManageProfileBody" -->
 <?php }}} ?>

    
    </body>

      </html>