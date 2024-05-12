
<!DOCTYPE html>
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
<html>


<head>
    <meta charset="UTF-8">
    <title>Partner List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
<style>
    .teaching-services {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
}

.teaching-services h3 {
    margin-bottom: 15px;
    font-size: 20px;
    color: #353535;;
}

.session-info {
  position: relative;
  background-color: #ffffff;
  border-radius: 10px;
  border: 0px solid silver;
  box-shadow: 0 1px 20px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  width: 300px;
  margin: 20px;
  display: inline-block;
}


.language {
    padding: 10px;
    display: inline-block;
}

.language h4 {
    font-size: 16px;
    color:#353535;;
}
.language h5{
    padding-top: 5px;
    font-size: 14px;
    color:#353535;
}

.language p {
    font-size: 14px;
    color: #8e9aaf;
}
    </style>
</head>
<body>
<?php include("LearnerHeaderFooter.php"); ?>




    <h2 id="h2session">Partner list</h2>
    <div class="scrollable-content">

    <?php 
 $sql =  "SELECT `photo`, `firstName`, `lastName`, `partnerID` , `email` FROM `partner`";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Error in SQL query: " . mysqli_error($connection));
}


?>
 <?php


while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="session-info">
            <img src="'.$row["photo"].'" id="Partnerpicture4" alt="Partner picture"> 
            <p>
                <span class="partner-details-lable">Partner Name:</span>
                <span class="artner-details">' . $row["firstName"] . ' ' . $row["lastName"] . '</span>
            </p> ';

    $sqll = "SELECT * FROM `service` WHERE `partnerEmail` = '" . $row["email"] . "'";
    $resusltt = mysqli_query($connection, $sqll);
    if ($resusltt) {
        $serviceCount = 0; // Counter to keep track of displayed services
        if (mysqli_num_rows($resusltt) > 0) {
            while ($roww = mysqli_fetch_array($resusltt)) {
                if ($serviceCount < 3) { // Display only the first two services
                    echo '
                        <div class="language">
                            <h4>' . $roww["langugeName"] . '</h4>
                            <h5></h5><p>' . $roww["level"] . '</p>
                            <h5></h5><p>' . $roww["price"] . ' SR/hour</p>
                        
                    </div>';
                    $serviceCount++;
                } else {
                    // If there are more services, display a message
                    echo '<br><br><p style="color: red;"class="partner-details-lable">  check my profile for more services</p> ';
                    break; // Exit the loop after displaying the message
                }
            }
        }
    }
    echo ' <div class="button-container2"><br>
    <button class="contact"  onclick="window.location.href=\'langaugelearningrequest.php?ID='.$row["partnerID"].'\'">Post request</button>
    <button class="buttonreview" onclick="window.location.href=\'partnerProfileForLearner.php?ID='.$row["partnerID"].'\'">Visit profile</button>
</div>
</div>';
}
?>
    </div>
 <?php   mysqli_close($connection); ?>
</body>

</html>