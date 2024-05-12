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
   
   
   
?>

<!DOCTYPE html>
<html>

<!--Editing language learning request
Author: renad-->

<head>
    <title>  Request Details </title>
    <meta charset="utf-8">
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!--header-->
    <?php include("LearnerHeaderFooter.php"); ?>
    <!--header end-->

    <div id="request-Post-box">
      
        <?php 
        // Retrieve the ID from $_GET or $_POST
        $ID = isset($_GET['ID']) ? $_GET['ID'] : (isset($_POST['ID']) ? $_POST['ID'] : null);
        $ID = mysqli_real_escape_string($connection, $ID); // Sanitize the ID to prevent SQL injection
        
        // Retrieve the request data based on the ID
        $sql = "SELECT `RequestID`, `LanguageName`, `learnerID`, `partnerID`, `level`, `preferredSchedule`, `sessionDuration`, `status`, `comment` FROM `request` WHERE `RequestID` = '$ID'";
        $result = mysqli_query($connection, $sql);
        if (!$result) {
            die("Error in SQL query: " . mysqli_error($connection));
        }
        $row = mysqli_fetch_assoc($result);
        ?>
          <h2> Language learning Request Details </h2>
          <h2 style="color: <?php echo getStatusColor($row["status"]); ?>;"> <?php echo $row["status"]; ?> </h2>
        <?php function getStatusColor($status) {
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
}?>
          <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="hidden" name="ID" value="<?php echo $ID; ?>">
            <label for="lang">The language you want to learn</label>
            <div>
                <select id="lang" name="language" disabled>
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
            <input type="radio" id="beginner" name="proficiency" value="Beginner" disabled <?php echo ($row['level'] == 'Beginner') ? 'checked' : ''; ?>>
            <label for="beginner">Beginner</label>
            <input type="radio" id="intermediate" name="proficiency" value="Intermediate" disabled <?php echo ($row['level'] == 'Intermediate') ? 'checked' : ''; ?>>
            <label for="intermediate">Intermediate</label>
            <input type="radio" id="advanced" name="proficiency" value="Advanced" disabled <?php echo ($row['level'] == 'Advanced') ? 'checked' : ''; ?>>
            <label for="advanced">Advanced</label><br>

            <label for="Date">Prefered schedule:</label>
            <input type="datetime-local" id="Date" name="schedule" value="<?php echo $row["preferredSchedule"]; ?>" disabled>

            <!--code adopted from w3schools:HTML Input Types
            url:https://www.w3schools.com/html/html_form_input_types.asp-->

            <label for="duration">Session duration</label>
            <select id="duration" name="Session_duration" disabled>
                <option value="" disabled>Select duration...</option>
                <?php
                $durations = array("30 min", "40 min", "50 min", "60 min", "100 min", "120 min");

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
            <textarea id="comments" disabled  name="comments" rows="4" cols="50" placeholder="Enter your comments here..."><?php echo $row["comment"]; ?></textarea>

            <div class="button-container2">
            <?php if (strtolower($row['status']) == 'pending') { ?>
              <button class="accept" type="button" onclick="window.location.href='Edit%20learnerSide%20request.php?ID=<?php echo $row['RequestID']; ?>'">Edit</button>
              <button class="reject" type="button"  onclick="window.location.href='CancelLearnerSideRequest.php?ID=<?php echo $row['RequestID']; ?>'">Delete</button>
              <?php } ?>
             
            </div>

        </form>
    </div>
   

    <?php mysqli_close($connection); ?>

</body>
</html>
