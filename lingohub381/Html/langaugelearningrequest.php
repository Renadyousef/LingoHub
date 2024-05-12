 <?php 
session_start();//at every page we need to access session varibles start session
$learner_id =$_SESSION['ID']; //$_SESSION['learner_id'];//set it in the session please at login page
$partner_id =$_GET['ID']; //$_SESSION['partner_id'];//ig related to post to be to partner
?>

<!DOCTYPE html>
<html>


<!--Posting language learning request Author:renad-->


<head>
    <title>learner Request</title>
    <meta charset="utf-8">
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
   <?php
    //including footer and header
    include("LearnerHeaderFooter.php"); 

    ?>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script>
// Check the preferred schedule to be available from today until forward, not in the past
var dateValid, timeValid;
$(document).ready(function() {
    // Validate date reservations 
//     function validateDate() {
//         var dateInput = $('#Date').val();
//         var selectedDate = new Date(dateInput); // selected date
//         var now = new Date(); // Current date and time of the day

//         // Check if the selected date is today or in the future
//         if (selectedDate < now) {
//             $('#dateValidationMessage').text("Please don't select dates in the past.").css("color", "red");
//             return false;
//         } else {
//             $('#dateValidationMessage').text(""); // Clear any previous error message
//             return true;
//         }
//     }

//     // Validate time being in the future
//     function validateTime() {
//     var timeInput = $('#time').val();
//     var now = new Date();
//     var selectedTime = new Date(now.toDateString() + ' ' + timeInput);

//     // Check if the selected time is in the future
//     if (selectedTime < now) {
//         $('#timeValidationMessage').text("Please select a time that is not in the past.").css("color", "red");
//         return false;
//     } else {
//         $('#timeValidationMessage').text(""); // Clear any previous error message
//         return true;
//     }
// }
function validateTime() {
    var dateInput = $('#Date').val();
    var timeInput = $('#time').val();
    var selectedDateTime = new Date(dateInput + ' ' + timeInput);
    var now = new Date();

    // Check if the selected date and time is in the future
    if (selectedDateTime < now) {
        $('#timeValidationMessage').text("Please select a date and time that is not in the past.").css("color", "red");
        return false;
    } else {
        $('#timeValidationMessage').text(""); // Clear any previous error message
        return true;
    }
}

    // Call function when user finishes picking time at blur
    $('#Date').blur(function() {
        dateValid = validateDate();
    });
    $('#time').blur(function() {
        timeValid = validateTime();
    });

    // Prevent submission if not valid
    $('form').submit(function(event) {
        dateValid = validateDate(); // Update date validity
        timeValid = validateTime(); // Update time validity
        if (dateValid && timeValid) {
            alert("Your request has been posted successfully!");
            // Redirect to the learner_request.php page
            window.location.href = "learnerReq.php";
        } else {
            // Prevent form submission if not valid
            event.preventDefault();
            alert("Please insert available date and time inputs before submitting.");
        }
    });
});
</script>

<!--js end and it does work right-->

</head>

<body>
   
<div id="request-Post-box">

    <h2>find the right tutor for you</h2>
<div class="redNote" >Note:all fileds with * are required</div>
    <form method="post"  action="../PHP/post.php">
    <input type="hidden" name="ID" value="<?php echo $partner_id ; ?>">
    <label for="lang" class="required">The language you want to learn</label>
    <div>
        <select id="lang" name="language" required> 
            <option value="" disabled selected>Select a language...</option> <!-- Added a placeholder -->
        <option value="Afrikaans">Afrikaans</option>
        <option value="Albanian">Albanian</option>
        <option value="Arabic">Arabic</option>
        <option value="Armenian">Armenian</option>
        <option value="Basque">Basque</option>
        <option value="Bengali">Bengali</option>
        <option value="Bulgarian">Bulgarian</option>
        <option value="Catalan">Catalan</option>
        <option value="Cambodian">Cambodian</option>
        <option value="Chinese (Mandarin)">Chinese (Mandarin)</option>
        <option value="Croatian">Croatian</option>
        <option value="Czech">Czech</option>
        <option value="Danish">Danish</option>
        <option value="Dutch">Dutch</option>
        <option  value="English">English</option>
        <option value="Estonian">Estonian</option>
        <option value="Fiji">Fiji</option>
        <option value="Finnish">Finnish</option>
        <option value="French">French</option>
        <option value="Georgian">Georgian</option>
        <option value="German">German</option>
        <option value="Greek">Greek</option>
        <option value="Gujarati">Gujarati</option>
        <option value="Hebrew">Hebrew</option>
        <option value="Hindi">Hindi</option>
        <option value="Hungarian">Hungarian</option>
        <option value="Icelandic">Icelandic</option>
        <option value="Indonesian">Indonesian</option>
        <option value="Irish">Irish</option>
        <option value="Italian">Italian</option>
        <option value="Japanese">Japanese</option>
        <option value="Javanese">Javanese</option>
        <option value="Korean">Korean</option>
        <option value="Latin">Latin</option>
        <option value="Latvian">Latvian</option>
        <option value="Lithuanian">Lithuanian</option>
        <option value="Macedonian">Macedonian</option>
        <option value="Malay">Malay</option>
        <option value="Malayalam">Malayalam</option>
        <option value="Maltese">Maltese</option>
        <option value="Maori">Maori</option>
        <option value="Marathi">Marathi</option>
        <option value="Mongolian">Mongolian</option>
        <option value="Nepali">Nepali</option>
        <option value="Norwegian">Norwegian</option>
        <option value="Persian">Persian</option>
        <option value="Polish">Polish</option>
        <option value="Portuguese">Portuguese</option>
        <option value="Punjabi">Punjabi</option>
        <option value="Quechua">Quechua</option>
        <option value="Romanian">Romanian</option>
        <option value="Russian">Russian</option>
        <option value="Samoan">Samoan</option>
        <option value="Serbian">Serbian</option>
        <option value="Slovak">Slovak</option>
        <option value="Slovenian">Slovenian</option>
        <option value="Spanish">Spanish</option>
        <option value="Swahili">Swahili</option>
        <option value="Swedish ">Swedish </option>
        <option value="Tamil">Tamil</option>
        <option value="Tatar">Tatar</option>
        <option value="Telugu">Telugu</option>
        <option value="Thai">Thai</option>
        <option value="Tibetan">Tibetan</option>
        <option value="Tonga">Tonga</option>
        <option value="Turkish">Turkish</option>
        <option value="Ukrainian">Ukrainian</option>
        <option value="Urdu">Urdu</option>
        <option value="Uzbek">Uzbek</option>
        <option value="Vietnamese">Vietnamese</option>
        <option value="Welsh">Welsh</option>
        <option value="Xhosa">Xhosa</option>
        
    </select><br>

    </div>
    
    <!-- 
    Code above adapted from Stack Overflow: 
    "List of all country languages for dropdown select menu HTML FORM [closed]" 
    (https://stackoverflow.com/questions/38909766/list-of-all-country-languages-for-dropdown-select-menu-html-form)
    -->
    
    
    <label class="required">Proficiency Level:</label> <br>
    <input type="radio" id="beginner" name="proficiency" value="Beginner" required>
    <label for="beginner">Beginner</label>
    <input type="radio" id="intermediate" name="proficiency" value="Intermediate" required>
    <label for="intermediate">Intermediate</label>
    <input type="radio" id="advanced" name="proficiency" value="Advanced" required>
    <label for="advanced">Advanced</label><br>
    
    
    <!--new change-->
    <label for="Date" class="required">Prefered day:</label>
    <input type="date" id="Date" name="scheduleDate" required>
    <div id="dateValidationMessage"></div>
    <label for="time" class="required">time:</label>
    <input type="time" id="time" name="scheduleTime" required>
    <div id="timeValidationMessage"></div>
    <br><label for="duration" class="required">Session duration</label>
    <select id="duration" name="Session_duration" required>
    <option value="" disabled>Select duration...</option>
    <option>30 minutes</option>
    <option >40 minutes</option>
    <option>50 minutes</option>
    <option>60 minutes</option>
    <option>90 minutes</option>
    <option>120 minutes</option>
</select>

    
    <br>
    <label for="comments">Comments (Optional)</label><br>
    <textarea maxlength='400' id="comments" name="comments" maxlength="50" rows="4" cols="50" placeholder="Enter your comments here..."></textarea>
    
    <br><div class="form-group" id="submit-button-group">     <input type="submit" value="Submit" id="submit-btn"> </div>
  
 </form>
</div>

</body>
</html>

