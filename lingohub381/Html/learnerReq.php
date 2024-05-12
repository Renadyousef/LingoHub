<!DOCTYPE html>
<!-- Job requests for native partner Author: Renad01-->
<?php session_start();?>
<?php
$servername= "localhost";
$username= "root" ;
$password= "";
$dbname= "lingohub" ;
$connection= mysqli_connect($servername,$username,$password,$dbname);
$database= mysqli_select_db($connection, $dbname);
// Check the connection
if (!$connection) 
die("Connection failed: ".mysqli_connect_error());
?>
<head>
    <meta charset="UTF-8">
    <title>Job Request List</title>
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .scrollable-content {
            overflow-x: auto;
            white-space: nowrap;
        }
    </style>
   
</head>

<body>
    <!--header-->
    <?php include("LearnerHeaderFooter.php"); ?>
    <!--header end-->

    <?php 
//  $sql =  " SELECT `photo` , `firstName`, `lastName`, `partnerID`,  `LanguagePro`,  FROM `partner` WHere 'firstName'='Amanda'  ";
 $sql =  "SELECT `RequestID`, `LanguageName`, `learnerID`, `partnerID`, `level`, `preferredSchedule`, `sessionDuration`, `status`, `comment` FROM `request` where `learnerID` = {$_SESSION['ID']}";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Error in SQL query: " . mysqli_error($connection));
}


?>
 <h2 id="h2session">Posted Request</h2>
 <div class=" scrollable-content">
        <!-- <h3> Requests#1</h3> -->
        
        
 <?php
function getStatusColor($status) {
    $statusLower = strtolower($status); // Convert status to lowercase
    switch ($statusLower) {
        case "pending":
            return "grey";
        case "accepted":
            return "green";
        case "rejected":
            return "red";
        default:
            return "black"; // Default color
    }
}

if ($result->num_rows > 0) {
while($row = mysqli_fetch_assoc($result))
echo ' <div class="session-info"> 
<br>
<p>
<span class="partner-details-lable">Request# '. $row["RequestID"] .' </span>
<p>
<span class="partner-details-lable"> Language:</span>
<span class="spartner-details-language">' . $row["LanguageName"] . '</span>
<br>
<span class="partner-details-lable"> Proficiency Level:</span>
<span class="spartner-details-language">' . $row["level"] . '</span>
<br>
<span class="partner-details-lable"> Schedule:</span>
<span class="spartner-details-language">' . $row["preferredSchedule"] . '</span>
<br>
<span class="partner-details-lable"> Duration:</span>
<span class="spartner-details-language">' . $row["sessionDuration"] . '</span>
<br>
<span class="partner-details-lable" style="color: ' . getStatusColor($row["status"]) . ';">' . $row["status"] . '</span>

</p>

            </p>     

<div class="button-container2">
<button class="contact" onclick="window.location.href=\'reqDetails.php?ID=' . $row["RequestID"] . '\'">More Details</button>
</div> 
</div>

';


}else {
    echo '<div style="text-align: center;">';
    echo "<p><br><br><br><br><br><br>No Requests posted yet.</p>";
    echo '</div>';
}  
?>
   

   
   
            
        
      
    </div>
    
    <?php   mysqli_close($connection); ?>
    <!--footer-->

  
    <footer>
        <!-- <table class="tableF">
            <tr>
                <th><a href="aboutUs.html"> About Us </a></th>
                <th><a href="FAQ.html"> FAQs </a></th>
                <th><a href="ContactUs.html"> Contact Us </a></th>
            </tr>
        </table> -->
      <div class="icons">
                <h4>Share the website</h4>
            
                <a href="https://facebook.com" target="_blank">
                    <i class="fa-brands fa-facebook fa-2x"></i>
                </a>
        
                <a href="https://twitter.com" target="_blank">
                    <i class="fa-brands fa-twitter fa-2x"></i>
                </a>
        
                <a href="https://linkedin.com" target="_blank">
                    <i class="fa-brands fa-linkedin fa-2x"></i>
                </a>
        
                <a href="https://instagram.com" target="_blank">
                    <i class="fa-brands fa-instagram fa-2x"></i>
                </a>
        
                <a href="https://web.whatsapp.com" target="_blank">
                    <i class="fa-brands fa-whatsapp fa-2x"></i>
                </a>
                <br>
                lingo hub &copy; 2024
            </div>
    </footer>
    

</body>
</html>