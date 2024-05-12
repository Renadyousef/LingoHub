<?php session_start(); ?>
<?php
DEFINE ("servername","localhost");
DEFINE ("username","root");
DEFINE ("password","");
DEFINE("dbname","lingohub");
if (!$connection=mysqli_connect(servername, username, password)) 
    die("Connection failed: " . mysqli_connect_error());

if(!$database = mysqli_select_db($connection, dbname))
   die("Could not Open the " . dbname ."database" );
   $conflict = false;
   if (isset($_POST['edit_submit'])) {
       $ID = $_POST['ID'];
       $language = $_POST['language'];
       $proficiency = $_POST['proficiency'];
      $schedule = $_POST['schedule'];
    $schedulee = date('Y-m-d H:i:s', strtotime($_POST['schedule']));
       $sessionDuration = $_POST['Session_duration'];
       $comments = $_POST['comments'];
       
       $sql_existing_req = "SELECT * FROM `request` WHERE `learnerID` = '{$_SESSION['ID']}'";

       $result_existing_req = mysqli_query($connection,  $sql_existing_req );
    
       while ($existing_request = mysqli_fetch_assoc($result_existing_req)) {
          if($ID!=$existing_request['RequestID'] )
           if ($schedulee== $existing_request['preferredSchedule']){
           $conflict = true;
        break;
           }
       }
       if ($conflict){
       echo '<script> document.getElementById("schedule-error").innerHTML = "Time conflict with other request";</script>';
       $schedule = date('Y-m-d H:i:s', strtotime($_POST['schedule']));
       }
       else{
      
 // Update query
            $sql = "UPDATE `request` SET `LanguageName`='$language', `level`='$proficiency', `preferredSchedule`='$schedule', `sessionDuration`='$sessionDuration', `comment`='$comments' WHERE `RequestID` = '$ID'";
                
            $res = mysqli_query($connection, $sql);
            if ($res) {
                // If update is successful, redirect to the page where you display learner requests
                echo "<script>alert('Updated successfully');</script>";
                // Redirect to the learner request page
                header("Location: learnerReq.php");
                exit(); // Ensure script execution stops after redirection
            } else {
                echo "Error updating record: " . mysqli_error($connection);
            }
       }
      
   }
   
?>

<!DOCTYPE html>
<html>

<!--Editing language learning request
Author: renad-->

<head>
    <title>Edit learner Request</title>
    <meta charset="utf-8">
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />



</head>

<body>
    <!--header-->
    <?php include("LearnerHeaderFooter.php"); ?>
    <!--header end-->

    <div id="request-Post-box">
        <h2>Edit Language learning Request</h2>
        <?php 
        // Retrieve the ID from $_GET or $_POST
        $ID = isset($_GET['ID']) ? $_GET['ID'] : (isset($_POST['ID']) ? $_POST['ID'] : 1);
        $ID = mysqli_real_escape_string($connection, $ID); // Sanitize the ID to prevent SQL injection

      
        // Retrieve the request data based on the ID
        $sql = "SELECT `RequestID`, `LanguageName`, `learnerID`, `partnerID`, `level`, `preferredSchedule`, `sessionDuration`, `status`, `comment` FROM `request` WHERE `RequestID` = '$ID'";
        $result = mysqli_query($connection, $sql);
        if (!$result) {
            die("Error in SQL query: " . mysqli_error($connection));
        }
        $row = mysqli_fetch_assoc($result);
        ?>
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="hidden" name="ID" value="<?php echo $ID; ?>">
            <label for="lang">The language you want to learn</label>
            <div>
                <select id="lang" name="language" required>
                    <option value="" disabled>Select a language...</option>
                    <?php
                    // retrive language from language table to make sure that he select langague from table
                        $sqll = "SELECT `LanguageName` FROM `language`";
                        $resultt = mysqli_query($connection, $sqll);
                    
                        // Check if the query was successful
                        if ($resultt) {
                            // Fetch all language names into an array
                            $languages = mysqli_fetch_all($resultt, MYSQLI_ASSOC);
                    
                            // Free the result set
                            mysqli_free_result($resultt);
                        } else {
                            // Handle the case where the query failed
                            echo "Error: " . mysqli_error($connection);
                        }
                    
                    foreach ($languages as $language) {
                        echo '<option value="' . $language['LanguageName'] . '"';
                        if ($language['LanguageName'] == $row['LanguageName']) {
                            echo ' selected';
                        }
                        echo '>' . $language['LanguageName'] . '</option>';
                    }
                   
                    ?>
                </select><br>
            </div>

            <!-- Code above adapted from Stack Overflow: 
            "List of all country languages for dropdown select menu HTML FORM [closed]" 
            (https://stackoverflow.com/questions/38909766/list-of-all-country-languages-for-dropdown-select-menu-html-form) -->

            <label>Proficiency Level:</label> <br>
            <input type="radio" id="beginner" name="proficiency" value="Beginner" required <?php echo ($row['level'] == 'Beginner') ? 'checked' : ''; ?>>
            <label for="beginner">Beginner</label>
            <input type="radio" id="intermediate" name="proficiency" value="Intermediate" required <?php echo ($row['level'] == 'Intermediate') ? 'checked' : ''; ?>>
            <label for="intermediate">Intermediate</label>
            <input type="radio" id="advanced" name="proficiency" value="Advanced" required <?php echo ($row['level'] == 'Advanced') ? 'checked' : ''; ?>>
            <label for="advanced">Advanced</label><br>

            <label for="Date">Prefered schedule:</label>
            <div id="schedule-error" style="color: red;"></div>
        <?php
        if ($conflict) {
            $schedule_value = htmlspecialchars($_POST['schedule']); // Use submitted value if there's a conflict
        } else {
            $schedule_value = htmlspecialchars($row["preferredSchedule"]); // Use value from database if no conflict
        }
        ?>
            <input type="datetime-local" id="Date" name="schedule" value="<?php echo $schedule_value; ?>" required>
            <script>
        <?php
        if ($conflict) {
            $schedule = date('Y-m-d H:i:s', strtotime($_POST['schedule']));
            echo 'document.getElementById("schedule-error").innerHTML = "Time conflict with other request";';
        }
        ?>
    </script>
      
        
            <label for="duration">Session duration</label>
            <select id="duration" name="Session_duration" required>
            <option value="" disabled>Select duration...</option>
            <?php
     
            $durations = array("30 minutes", "40 minutes", "50 minutes", "60 minutes", "90 minutes", "120 minutes");

            foreach ($durations as $duration) {
                echo '<option value="' . $duration . '"';
                if ($duration == $row['sessionDuration']) {
                    echo ' selected';
                }
                echo '>' . $duration . '</option>';
            }
            ?>
        </select>

            <br>

            <label for="comments">Comments (Optional)</label><br>
            <textarea id="comments" name="comments" rows="4" cols="50" placeholder="Enter your comments here..."><?php echo $row["comment"]; ?></textarea>

            <div class="button-container2">
                <button class="accept" type="submit" name="edit_submit">Save Edit</button>
                <button class="reject" type="button" onclick="window.location.href='learnerReq.php'" name="delete-edit"> Cancel Edit</button>
            </div>

        </form>
    </div>
   

    <?php mysqli_close($connection); ?>

</body>
</html>
