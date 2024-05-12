
<?php //only job requests with pending status will apear,JOB REQUESTS FOR PARTNER RELATED PAGES 2
session_start();//i think i only need partner id here
$partner_id = $_SESSION['ID']; //do  i need partner id? i think yes

?>

<!DOCTYPE html>
<!-- Job requests for native partner Author: Renad01-->

<head>
    <meta charset="UTF-8">
    <title>Job Request List</title>
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <?php include("partnerHeaderFooter.php"); ?>
    </head>
    
  
<div id="Job-Request-list">
<h3>Job Requests for you</h3>
<ul >

<?php
   
//connection
$database = mysqli_connect('localhost', 'root', '');
if (!$database) {
    die('error at establishing a connection to data base !');
}
$select = mysqli_select_db($database, 'lingohub'); // opening db
if (!$select) {
    die('error at openeing a data base !');
}

    // Fetch requsts only pending  for partner 
    $query = "SELECT learner.*, request.*
    FROM learner
    JOIN request ON learner.learnerID = request.learnerID
    WHERE request.status = 'pending' AND request.partnerID = $partner_id";
    $result = mysqli_query($database, $query);
if(!$result){
    die('error at excuting query '.mysqli_error($database));
}
  
    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) { //just like fetch row but associtive
      
            echo '<li>';
            echo '<a href="ViewlanguageRequestDetailsPartnerSide.php?id=' . $row['RequestID'] . '">';//for now i sent id as prmmter in url
            echo '<span><img src="' . $row['photo'] . '" alt="Profile picture"></span>'; 
            echo '<span>' . $row['firstName'] . ' ' . $row['lastName'] . '</span>'; 
            echo '</a>';
            echo '</li>';
        }
    } else {

        echo '<li>No requests found.</li>';
    }

 mysqli_close($database);
?>
</ul>
</div>

   

</body>
</html>