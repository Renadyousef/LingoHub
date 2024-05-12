<?php
session_start();
$partner_id = $_SESSION['ID']; 

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Job request Details</title>
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" >
    <?php include("partnerHeaderFooter.php"); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".accept").click(function(){
                alert("You have accepted the request.");
            });

            $(".reject").click(function(){
                alert("You have rejected the request.");
            });
        });
    </script>
</head>

<body>
<?php
$database = mysqli_connect('localhost', 'root', '');
if(!$database){
    die('Error at establishing a connection to the database!');
}
$select=mysqli_select_db($database,'lingohub');
if(!$select){
    die('Error at opening the database!');  
}

$request_id = $_GET['id'];

$query = "SELECT * FROM request WHERE RequestID = '$request_id'";
$result = mysqli_query($database, $query);

if (!$result) {
    die('Error at query execution: ' . mysqli_error($database));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $language = $row['LanguageName'];
    $proficiency_level = $row['level'];
    $preferred_schedule = $row['preferredSchedule'];
    $session_duration = $row['sessionDuration'];
    $comments = $row['comment'];
    $posted_timestamp = strtotime($row['post_time']);
    $expiration_timestamp = $posted_timestamp + (24 * 3600);

    if (time() < $expiration_timestamp) {
        echo '<div id="My-RequestsLearner">';
        echo '<ul>';
        echo '<li>';
        echo '<h3> Request#' . $request_id . '</h3>';
        echo '<p class="redNote">Note: You have 24 hours to accept or reject; otherwise, the request will be automatically withdrawn!</p>';
        echo '<div id="the-final-countdown">';
        echo '<p></p>';
        echo '</div>';
        echo '<p>Language: ' . $language . '</p>';
        echo '<p>Proficiency Level: ' . $proficiency_level . '</p>';
        echo '<p>Preferred Schedule: <time datetime="' . $preferred_schedule . '">' . $preferred_schedule . '</time></p>';
        echo '<p>Duration: ' . $session_duration . ' minutes</p>';
        echo '<p>Comments: ' . $comments . '</p>';
     
        echo '<div class="button-container2">';
        echo '<form action="../PHP/process_request.php" method="post">';
        echo '<input type="hidden" name="request_id" value="' . $request_id . '">';
        echo '<input type="hidden" name="action" value="accept">';
        echo '<input type="hidden" name="preferred_schedule" value="' . $preferred_schedule . '">';
        echo '<input type="hidden" name="session_duration" value="' . $session_duration . '">';
        echo '<button type="submit" class="accept">Accept</button>';
        echo '</form>';
        
        echo '<form action="../PHP/process_request.php" method="post">';
        echo '<input type="hidden" name="request_id" value="' . $request_id . '">';
        echo '<input type="hidden" name="action" value="reject">';
        echo '<input type="hidden" name="preferred_schedule" value="' . $preferred_schedule . '">';
        echo '<input type="hidden" name="session_duration" value="' . $session_duration . '">';
        echo '<button type="submit" class="reject">Reject</button>';
        echo '</form>';
        echo '</div>';
        
        echo '</li>';
        echo '</ul>';
        echo '</div>';
    } else {
        echo "<script>alert('Sorry, the request has expired!');
        window.location.href = 'jobRequestlist.php'; </script>";
    }

    mysqli_close($database);
} else {
    echo 'Request not found.';
    mysqli_close($database);
}
?>
</body>
</html>
