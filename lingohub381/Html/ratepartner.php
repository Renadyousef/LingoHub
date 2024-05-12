<!DOCTYPE html>
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
   	   <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>ViewRateAndReviews</title>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <link href="../css/styles.css" type="text/css" rel="stylesheet">
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   </head>
<body>
<?php include("LearnerHeaderFooter.php"); ?>

    <?php 
$sql =  "SELECT `reviewID`, `sessionID`, `learnerfname`, `learnLname`, `partnerID`, `comment`, `posted_rate`, `rating` FROM `review`  where partnerID=" . $_GET['ID'] .";";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Error in SQL query: " . mysqli_error($connection));
}
?>
<?php
if (mysqli_num_rows($result) > 0) {
    // Reviews are available, display them
    echo '<h2 id="h2session">Rate and Reviews</h2>';
    echo '<div class="outerDiv">';
    while($row = mysqli_fetch_assoc($result)) {
        echo '<div class="SubDiv"> 
                  <div class="innerDiv"> 
                      <img class="userImg" src="defultpic.jpg" alt="userImg">
                      <Strong class="Reviewers">' . $row["learnerfname"] . ' ' . $row["learnLname"] . '</Strong><br>
                      <p class="date">' . $row["posted_rate"] . '</p>
                      <span class="fa fa-star checked"></span>
                      <span class="fa fa-star checked"></span>
                      <span class="fa fa-star checked"></span>
                      <span class="fa fa-star unchecked"></span>
                      <span class="fa fa-star unchecked"></span>
                      <p>' . $row["comment"] . '</p>
                  </div>
              </div>';
    }
    echo '<div class="button-container2">
              <button class="contact" onclick="window.location.href=\'partnerList.php\'">Back</button>
          </div>';
    echo '</div>';
} else {
    // No reviews available, display message
    echo '<h2 id="h2session">No review posted yet</h2>';
    echo '<div class="button-container2">
              <button class="contact" onclick="window.location.href=\'partnerList.php\'">Back</button>
          </div>';
}
?>
      </div>
    
      <br><br>

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
