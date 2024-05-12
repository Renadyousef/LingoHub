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
    <title>Partner Info</title>
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

.language-box {
    display: inline-block;
    width: 120px; /* Adjust width as needed */
    height: 135px; /* Adjust height as needed */
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-right: 10px; /* Adjust margin between boxes */
    vertical-align: top;
    margin-bottom: 6px;
    position: relative;
}

.language {
    padding: 10px;
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
<body >
<?php include("LearnerHeaderFooter.php"); ?>


<?php 
$sql =  "SELECT `photo`, `firstName`, `lastName`, `partnerID`,  `bio` ,`email`  FROM `partner` where partnerID=" . $_GET['ID'] .";";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Error in SQL query: " . mysqli_error($connection));
}
?>
<div class="ManageProfileBody">
<?php while($row = mysqli_fetch_assoc($result)): ?>
    <div class="left">
        <img src="<?php echo $row["photo"]; ?>" id="img" alt="Personal photo">
        <div class="info_data">   
            <span class="partner-details-lable">Partner Name:</span>
            <span class="partner-details"><?php echo $row["firstName"] . ' ' . $row["lastName"]; ?></span><br><br>
            <span class="partner-details" style="text-decoration: underline;"><a href="mailto:<?php echo $row['email']; ?>">Contact me!</a></span>
        </div>
    </div>
    <div class="right session-info scrollabley">
        <br>
        <p>
            <span class="partner-details-bio-label">Bio:</span>
            <span class="partner-details-bio"><?php echo $row["bio"]; ?></span><br>
         
        </p> 
 <a href="ratepartner.php?ID=<?php echo $row["partnerID"]; ?> "><span class="fa fa-star checked"></span></a>
<a href="ratepartner.php?ID=<?php echo $row["partnerID"]; ?>"><span class="fa fa-star checked"></span></a>
<a href="ratepartner.php?ID=<?php echo $row["partnerID"]; ?>"><span class="fa fa-star unchecked"></span></a>
<a href="ratepartner.php?ID=<?php echo $row["partnerID"]; ?>"><span class="fa fa-star unchecked"></span></a>
<a href="ratepartner.php?ID=<?php echo $row["partnerID"]; ?>"><span class="fa fa-star unchecked"></span></a>
     
        <br>
        <h3>Teaching Services</h3>
        <?php
        $sqll = "SELECT * FROM `service` WHERE `partnerEmail` = '" . $row["email"] . "';";
        $resusltt = mysqli_query($connection, $sqll);
        if ($resusltt) {
            if (mysqli_num_rows($resusltt) > 0) {
                while ($roww = mysqli_fetch_array($resusltt)) {
        ?>
                    <div class="language-box">
                        <div class="language">
                            <h4><?php echo $roww["langugeName"]; ?></h4>
                            <h5>Proficiency:</h5><p><?php echo $roww["level"]; ?></p>
                            <h5>Price:</h5><p><?php echo $roww["price"]; ?>/hour</p>
                        </div>
                    </div>
        <?php
                }
            }
        }
        ?>
      
    </div>
<?php endwhile; ?>
</div>
<?php mysqli_close($connection); ?>
<footer>
    <div class="icons">
        <h4>Share the website</h4>
        <a href="https://facebook.com" target="_blank"><i class="fa-brands fa-facebook fa-2x"></i></a>
        <a href="https://twitter.com" target="_blank"><i class="fa-brands fa-twitter fa-2x"></i></a>
        <a href="https://linkedin.com" target="_blank"><i class="fa-brands fa-linkedin fa-2x"></i></a>
        <a href="https://instagram.com" target="_blank"><i class="fa-brands fa-instagram fa-2x"></i></a>
        <a href="https://web.whatsapp.com" target="_blank"><i class="fa-brands fa-whatsapp fa-2x"></i></a><br>
        lingo hub &copy; 2024
    </div>
</footer>
</body>
</html>
