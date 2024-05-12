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
        <!-- <link href="../css/styles.css" type="text/css" rel="stylesheet"> -->
        <link href="../css/profile.css" type="text/css" rel="stylesheet">
        <style>.ManageProfileBody{
         margin-top: 400px;
         width: 800px;
        height: 750px;
} </style>

</head>

<body id = "ProfileManage">
<?php include("partnerHeaderFooter.php"); ?>

<?php
   $sql = "SELECT * FROM `partner` WHERE partnerID = '" . $_SESSION['ID'] . "'";
 
   $resuslt = mysqli_query($connection,$sql);
   if($resuslt){
      if(mysqli_num_rows($resuslt)>0){
          while($row = mysqli_fetch_array($resuslt)){
?>

 <div class ="ManageProfileBody" >
        <div class="left">
            <img src="<?php echo $row['photo']; ?>" id="img" alt="Personal photo">   
            <div class="button-container2">
                        <button class="accept" onclick="window.location.href='partner-EditProfile.php'">Edit profile</button>
                        <button class="reject " onclick="window.location.href='partner-deleteprofile.php'">Delete profile</button>
                    </div>
            
        </div>

        <div class="right">
                       
                        <h3>MY Profile</h3>
                     <div class="info_data">
                        <div class="data">
                            <h4>First name</h4> 
                            <p> <?php echo $row['firstName']; ?></p>
                            <h4>age</h4> 
                            <p><?php echo $row['age']; ?></p>
                            <h4>Email</h4> 
                            <p><?php echo $row['email']; ?></p>
                            <h4>city</h4> 
                            <p><?php echo $row['city']; ?></p>
                        
                         </div>
                         <div class="data">
                            <h4>Last name</h4>
                            <p><?php echo $row['lastName']; ?></p>
                            <h4>gender</h4>
                            <p><?php echo $row['gender']; ?>e</p>
                            <h4>phone</h4> 
                            <p>0556199919</p>
                            <h4>bio</h4>  
                            <p id="textMultiline" >
                            <?php echo $row['bio']; ?>
                            </p>
                            <br><br><br><br>
                         </div>    

                    </div><?php }}} ?>
                    <h3>Teaching Services</h3>
                    <?php
       $sql = "SELECT * FROM `service` WHERE `partnerEmail` = '" . $_SESSION["email"] . "'";
       $resuslt = mysqli_query($connection,$sql);
       if($resuslt){
      if(mysqli_num_rows($resuslt)>0){
          while($row = mysqli_fetch_array($resuslt)){
       ?>
                    <div class="language-box">
                        <div class="language">
                            <h4><?php echo $row['langugeName']; ?></h4>
                         <h5>Proficiency:</h5 ><p> <?php echo $row['level']; ?></p>
                         <h5>Price:</h5 > <p><?php echo $row['price']; ?> SR/hour</p>
                        </div>
                    </div> <?php }}} ?>
   
                    
                    
         </div><!--End of class "right" --> 

 </div><!--End of class "ManageProfileBody" -->



    
    </body>
 
      </html>