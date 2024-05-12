<?php //delete request
session_start();
//might need the request id

DEFINE ("servername","localhost");
DEFINE ("username","root");
DEFINE ("password","");
DEFINE("dbname","lingohub");
if (!$connection=mysqli_connect(servername, username, password)) 
    die("Connection failed: " . mysqli_connect_error());

    
if(!$database = mysqli_select_db($connection, dbname))
   die("Could not Open the " . dbname ."database" );
   if(isset($_POST['delete_request'])) {
  
    // Passwords match, proceed with deletion
    $ID = $_POST['ID'];
    
    // Your database connection code
    
    $delete_query = "DELETE FROM `request` WHERE `RequestID` = '$ID'";
    $delete_result = mysqli_query($connection, $delete_query);
    
    if($delete_result) {
        echo "<script>alert('Deleted successfully');</script>";
        header("Location: learnerReq.php");
        exit();
    } else {
        echo "Error deleting request: " . mysqli_error($connection);
    }


}
mysqli_close($connection);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cancel Language Learning Request</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
    <script>
function cancelFormSubmission() {
    event.preventDefault();
    window.location.href = 'learnerReq.php';
}
</script>
</head>

<body>
    <?php include("LearnerHeaderFooter.php");
     $ID = isset($_GET['ID']) ? $_GET['ID'] : (isset($_POST['ID']) ? $_POST['ID'] : null);
      ?>
    <div class="Cancel-background-container">
        <form method='post' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>'>
            <div class="ManageCancelBody">
                <h3>Cancel Request</h3>
                <h4>Are you sure you want to cancel this request?</h4>
                <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                <input type="hidden" name="confirmed_cancel" id="confirmed_cancel" value="false">
                <div class="button-container5">
                    <button class="reject"  name="delete_request" >Cancel Request</button>
                    <button class="accept" onclick="cancelFormSubmission()" >Don't <br>Cancel </button>
                </div>
            </div>
        </form>
    </div>

    <!-- <script>
        function cancelRequest() {
            let flag = confirm("Are you sure you want to cancel this request?");
            if (flag) {
                $('#confirmed_cancel').val('true');//hidden input help if ok will delete
                $('form').submit();
            }
        }

        function keepRequest() {
            let flag = confirm("Are you sure you want to retain this request?");
            if (flag) {
                alert("Request has been retained");
                window.location.href = "learnerReq.php";
            }
        }
    </script> -->

</body>

</html>
