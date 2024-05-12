<?php //proccess when accept or rejected ,JOB REQUESTS FOR PARTNER RELATED PAGES 13
session_start();
$partner_id = $_SESSION['ID']; // i need partner id

/*
i passed request id and if its an aacsept or reject as hidden input with in the 2 forms
 both of them will be procceesed on this page but we cn tell diffrence accept or reject based on 'action'
 hiddent input

 also  $session_duration and $preferred_schedule sent them of current request as hidden 
*/
//connection
$database = mysqli_connect('localhost', 'root', '');
if (!$database) {
    die('error at establishing a connection to data base !');
}
$select = mysqli_select_db($database, 'lingohub'); // opening db
if (!$select) {
    die('error at openeing a data base !');
}


if ($_SERVER["REQUEST_METHOD"] == "POST") { // when job request (accept or reject) was submitted

    // retrieve the request ID that i sent as a hidden input so we can compare current with saved requests on data base
    $request_id = $_POST['request_id'];
    $action = $_POST['action']; // action  (accept or reject) also sent hidden 


    function checkConflict($partner_id, $preferred_schedule, $session_duration, $database)
    {
        
$new_request_end_time = strtotime($preferred_schedule) + intval($session_duration) * 60;
 $preferred_date = date('Y-m-d', strtotime($preferred_schedule));
        
        // conflict checked in query 
        $query = "SELECT * FROM request 
                  WHERE partnerID = ? 
                  AND DATE(preferredSchedule) = ? 
                  AND status = 'accepted'
                  AND (preferredSchedule < ? + INTERVAL ? MINUTE) 
                  AND (preferredSchedule + INTERVAL ? MINUTE > ?)";
        
// Prepare the statement bc we used prepared statemtns

$statement = mysqli_prepare($database, $query);
        
   
 mysqli_stmt_bind_param($statement, "isssss", $partner_id, $preferred_date, $preferred_schedule, $session_duration, $session_duration, $preferred_schedule);
        
      
mysqli_stmt_execute($statement);
        
 $result = mysqli_stmt_get_result($statement);
        
        // Check if any overlapping requests were found
        if (mysqli_num_rows($result) > 0) {
            return true; // Conflict found
        } else {
            return false; // No conflicts found
        }
    }
    
    
    
    

   //if accepted
    if ($action === 'accept') {
        // retrieving hidden inputs
        $preferred_schedule = $_POST['preferred_schedule'];
        $session_duration = $_POST['session_duration'];

        // Call  conflict function
        $conflict =checkConflict($partner_id, $preferred_schedule, $session_duration, $database);

        if ($conflict) {//it should be rejected by system if we encounter a confllict
           
            $query = "UPDATE request SET status = 'rejected' WHERE RequestID = '$request_id'";
            $result = mysqli_query($database, $query);
            
            echo "<script>alert('Error: Conflicts with existing requests! you cant have overlaping sessions');
            window.location.href = '../Html/jobRequestlist.php'; </script>";
        } else {
          //no conflict they can accept changing it in db
            $query = "UPDATE request SET status = 'accepted' WHERE RequestID = '$request_id'";
            $result = mysqli_query($database, $query);

            if ($result) {
                //insert here
                echo "<script>alert('Request accepted successfly!');
                window.location.href = '../Html/jobRequestlist.php'; </script>";
            } else {
                echo 'Error accepting the request: ' . mysqli_error($database);
            }
        }
    } elseif ($action === 'reject') {
    
        $query = "UPDATE request SET status = 'rejected' WHERE RequestID = '$request_id'";
        $result = mysqli_query($database, $query);

        if ($result) {//for testing remove later  add alert then redirect
            echo "<script>alert('Request rejected successfly!');
            window.location.href = '../Html/jobRequestlist.php'; </script>";
        } else {
            echo 'Error rejecting the request: ' . mysqli_error($database);//for testing
        }
    } else {
        echo 'Invalid action.';
    }
} else {
    echo 'Form was not submitted.';
}

mysqli_close($database);

