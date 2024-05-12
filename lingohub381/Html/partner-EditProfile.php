
   
      <?php
      session_start();
$servername= "localhost";
$username= "root" ;
$password= "";
$dbname= "lingohub" ;
$connection= mysqli_connect($servername,$username,$password,$dbname);
  if (!$connection) // Check the connection
     die("Connection failed: " . mysqli_connect_error());
$database= mysqli_select_db($connection, $dbname);

if(isset($_POST['submit'])) {
  $fname = '';
  $lname = '';
  $email = '';
  $city = '';
  $gender = '';
  $age='';
  $password = '';
  $photo='';
  $bio=' ';
  $phone='';

    if (isset($_POST["deletedLanguages"])) {
        // Get the deleted language names from the form
        $deletedLanguages = $_POST["deletedLanguages"];
       // Split the comma-separated string of language names into an array
        $deletedLanguageNames = explode(",", $deletedLanguages);
        foreach ($deletedLanguageNames as $languageName) {
           $sql2 = "DELETE FROM`service` WHERE langugeName = '$languageName'";
           mysqli_query($connection, $sql2);
         }}

    if(isset($_POST['language'])&&isset($_POST['level'])&&isset($_POST['price'])){
        $language = $_POST['language'];
        $level = $_POST['level'];
        $price = $_POST['price'];
        $checkQuery = "SELECT * FROM `service` WHERE partnerEmail = '" . $_SESSION["email"] . "' AND langugeName = '$language'";
        $checkResult = mysqli_query($connection, $checkQuery);
        if (mysqli_num_rows($checkResult) > 0) {
            // Primary key already exists, show client-side error message
            echo '<script>alert("Language already exists for this partner.");window.location.href="partner-EditProfile.php";</script>';
            exit;}
        else{
            $query = "INSERT INTO `service` (`partnerEmail`, `langugeName`, `level`, `price`) VALUES ('" . $_SESSION["email"] . "', '$language', '$level', '$price')";

        $result = mysqli_query($connection, $query);}}
        if ($result) {
            // Query executed successfully
            echo '<script>alert("Your edits have been sent successfully!");window.location.href="partner-EditProfile.php";</script>';
            exit;
        } else {
            // Query execution failed
            echo '<script>alert("Error: ' . mysqli_error($connection) . '");</script>';
        }

    // Fetching existing partner data from the database
    $sql = "SELECT * FROM `partner` WHERE partnerID = '" . $_SESSION['ID'] . "'";
    $results = mysqli_query($connection, $sql);
    if( mysqli_num_rows($results) > 0) {
        $row = mysqli_fetch_array($results);

         // Updating variables with form data or existing data if form data is not provided
         $fname = isset($_POST['firstName']) && $_POST['firstName'] !== "" ? $_POST['firstName'] : $row['firstName'];
         $lname = isset($_POST['lastName']) && $_POST['lastName'] !== "" ? $_POST['lastName'] : $row['lastName'];
         $email = isset($_POST['email']) && $_POST['email'] !== "" ? $_POST['email'] : $row['email'];
         $city = isset($_POST['city']) && $_POST['city'] !== "" ? $_POST['city'] : $row['city'];
         $gender = isset($_POST['gender']) && $_POST['gender'] !== "" ? $_POST['gender'] : $row['gender'];
         $age = isset($_POST['age']) && $_POST['age'] !== "" ? $_POST['age'] : $row['age'];
         $password = isset($_POST['password']) && $_POST['password'] !== "" ? mysqli_real_escape_string($connection, $_POST['password']) : $row['password'];
         $photo=isset($_POST['personal-pic']) && $_POST['personal-pic'] !== "" ? $_POST['personal-pic'] : $row['photo'];
         $bio = isset($_POST['bio']) && $_POST['bio'] !== "" ? $_POST['bio'] : $row['bio'];
         $phone=isset($_POST['phone']) && $_POST['phone'] !== "" ? $_POST['phone'] : $row['phone'];
         if(isset($_FILES['personal-pic']) && is_uploaded_file($_FILES['personal-pic']['tmp_name']) && $_FILES['personal-pic']['error'] === UPLOAD_ERR_OK) {
            // Handle file upload
            $photo = $_FILES['personal-pic']['name'];
            $targetDir = __DIR__ . "/"; // Specify your target directory
            $targetFile = $targetDir . basename($_FILES["personal-pic"]["name"]);
            move_uploaded_file($_FILES["personal-pic"]["tmp_name"], $targetFile);
        } else {
            // If no file is uploaded or an error occurred
            $photo = isset($_POST['personal-pic']) && $_POST['personal-pic'] !== "" ? $_POST['personal-pic'] : $row['photo']; 
        }
        
    }

     // Update query
     $sql3 = "UPDATE `partner` SET `firstName`='$fname', `lastName`='$lname', `email`='$email', `password`='$password', `age`='$age', `gender`='$gender', `city`='$city', `photo`='$photo', `bio`='$bio' , `phone`='$phone' WHERE partnerID = '" . $_SESSION['ID'] . "'";
     $res = mysqli_query($connection, $sql3);

     if($res) {
        echo '<script>alert("Your edits have been sent successfully!");window.location.href="partner-EditProfile.php";</script>';
        exit;
     } else {
        echo '<script>alert("Error updating records!");</script>';
     }
}


?>

<!DOCTYPE html>

<html>

    <head>
      
        <meta charset="UTF-8">
        <title>Edit Profile</title>
        <link href="../css/profile.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- <link href="../css/styles.css" type="text/css" rel="stylesheet"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
   
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <style>
        .ManageProfileBody{
         margin-top: 400px;}
         .ManageProfileBody .right textarea  {
      border: 1px solid #ddd;
      border-radius: 3px;
      color: #8e9aaf;
      padding: 4px;
      height: 100px;
      position: relative;
      margin-top: 1px;
      width: 250px;
      background: hwb(0 100% 0%);
      
    }
         </style>
<script>
$(document).ready(function (){
   var isFnameValid = true;
   var isLnameValid = true;
   var isEmailValid = true;
   var isPasswordValid = true;
   var isImgValid = true;
   var isPhoneValid = true;
   var ischangeCiti=false;
   var isvalidBio=true;

   function validateFirstName() {
        var firstName = $('#firstName').val();
        // Regular expression for validating first name: At least 2 alphabetic characters
        var firstNameRegex = /^[A-Za-z]{2,}$/;
        if (firstNameRegex.test(firstName) || firstName === "") {
            isFnameValid = true; 
            $('#firstNameError').text("");
        } else { 
            isFnameValid = false;     
            $('#firstNameError').text("Please enter a name with at least two letters").css({ "color": "red","font-size": "12px"});
        }
        enableSaveButton();
    }

    function validateLastName() {
        var lastName = $('#lastName').val();
        // Regular expression for validating last name: At least 2 alphabetic characters
        var lastNameRegex = /^[A-Za-z]{2,}$/;
        if (lastNameRegex.test(lastName) || lastName === "") {
           isLnameValid=true;
           $('#lastNameError').text("");
        } else {
            isLnameValid=false;
            $('#lastNameError').text("Please enter a name with at least two letters").css({ "color": "red","font-size": "12px"});
        }
        enableSaveButton();
    }
    function validateEmailAddress() {
    var email = $("#email").val();
    var emailRegex = /^\S+@\S+\.com$/;
    if (emailRegex.test(email) || email === "") {
        $.ajax({
            url: "checkP_email.php",
            method: "POST",
            data: { email: email },
            success: function(response) {
                if (response === "exists") {
                    isEmailValid = false;
                    $('#emailError').html("This email is already registered <br> Please enter a different email.").css({ "color": "red", "font-size": "12px" });
                } else {
                    isEmailValid = true;
                    $('#emailError').text("");
                }
                enableSaveButton();
            }
        });
    } else {
        isEmailValid = false;
        $('#emailError').html("Please enter a valid email address<br> in this format localpart@domain.com .").css({ "color": "red", "font-size": "12px" });
        enableSaveButton();
    }
}
  
   function validateUserPassword() {
        var passwordInput = $("#password").val();
        // Regular expression for validating passwords
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        if (passwordRegex.test(passwordInput) || passwordInput === "") {
            isPasswordValid = true;
            $('#passwordError').text("");
        } else {
         isPasswordValid = false;
            $('#passwordError').html("Your password needs to be:<br>- at least 8 characters<br>- include both lowercase and uppercase letters<br>- include at least one number.").css({ "color": "red","font-size": "12px"});
        }
        enableSaveButton();
      }

   function validateImage() {
        var fileInput = $('#personal-pic')[0]; // Access the file input element
        var file = fileInput.files[0];

        // Check the file type
        var allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            isImgValid = false;
            $('#imgError').text("Only JPG, PNG, and GIF files are allowed.").css({ "color": "red", "font-size": "12px" });
            enableSaveButton();
            return;
        }
        // Check the file size (in bytes)
        var maxSize = 5 * 1024 * 1024; // 5 MB
        if (file.size > maxSize) {
            isImgValid = false;
            $('#imgError').text("File size exceeds the maximum limit of 5MB.").css({ "color": "green", "font-size": "12px" });
            enableSaveButton();
            return;
        }  
        // Image is valid
         isImgValid = true;
         $('#imgError').text("image was uploaded successfully").css({ "color": "#008000", "font-size": "12px" }); // Clear any previous error message

        enableSaveButton();
    }
    function validatePhoneNumber() {
    var phone = $("#PhoneNumber").val();
    var phoneRegex = /^05\d{8}$/; // Phone number format: Starts with "05" followed by 8 digits

    if (phoneRegex.test(phone) || phone === "") {
        $.ajax({
            url: "check_phone.php",
            method: "POST",
            data: { phone: phone },
            success: function(response) {
                if (response === "exists") {
                    isPhoneValid = false;
                    $('#PhoneNumberError').html("This phone number is already registered. Please enter a different phone number.").css({ "color": "red", "font-size": "12px" });
                } else {
                    isPhoneValid = true;
                    $('#PhoneNumberError').text("");
                }
                enableSaveButton();
            }
        });
    } else {
        isPhoneValid = false;
        $('#PhoneNumberError').html("Please enter a valid 10-digit phone number.").css({ "color": "red", "font-size": "12px" });
        enableSaveButton();
    }
}


function validateBio() {
    var maxLength = 160;
    var bio = $("#bio").val();
    var remainingChars = maxLength - bio.length; 
    if (remainingChars < 0) {
        $('#BioError').text("Bio must be less than 160 characters.").css({ "color": "red", "font-size": "12px" });
        isvalidBio = false; // Flagging bio as invalid
    } else {
        $('#BioError').text(""); // Clearing error message
        isvalidBio = true; // Flagging bio as valid
    }
    enableSaveButton();
}





    function enableSaveButton() {
        if ((isFnameValid && isLnameValid && isEmailValid && isPasswordValid && isImgValid&&isvalidBio)) {
            $('#Save').prop("disabled", false);
        } else {
            $('#Save').prop("disabled", true);
        }
    }

    $('#firstName').on('input', validateFirstName);
    $('#lastName').on('input', validateLastName);
    $('#email').on('input', validateEmailAddress);
    $('#password').on('input', validateUserPassword);
    $('#personal-pic').on('change', validateImage);
    $('#city').on('change', function () {ischangeCiti=true; 
        $('#Save').prop("disabled", false); });
    $('#age').on('change', function () {ischangeCiti=true; 
        $('#Save').prop("disabled", false); });
    $('input[name="gender"]').on('change', function () { 
        ischangeCiti = true;
         $('#Save').prop("disabled", false); });
    $('#PhoneNumber').on('input', validatePhoneNumber);
    $('#bio').on('input', validateBio);
    $("#myForm").submit(function(event) {
        if (($('#firstName').val() === "" && $('#lastName').val() ==="" &&  $('#email').val() === "" && $('#password').val() === "" && $('#PhoneNumbe').val() === "" && ischangeCiti === false)) {
        event.preventDefault();
        }else
        if(isvalidprice==true){
        var confirmSubmit = window.confirm("Are you sure you want to save the changes?");
        if (!confirmSubmit ) {
             event.preventDefault();
           }}

    })
    
    document.querySelectorAll('.delete-language').forEach(icon => {
    icon.addEventListener('click', function() {
        $('#Save').prop("disabled", false); 
        // Retrieve the language name from the data attribute of the trash icon
        const languageName = this.dataset.languageName;
        // Remove the language box from the page
        const languageBox = this.closest('.language-box');
        languageBox.remove();
        // Retrieve the currently deleted languages from the hidden input field
        let deletedLanguages = document.getElementById('deletedLanguagesInput').value.split(',');
        // Add the deleted language to the array
        deletedLanguages.push(languageName);
        // Set the updated list of deleted languages as the value of the hidden input field
        document.getElementById('deletedLanguagesInput').value = deletedLanguages.join(',');

        
    });
});

document.getElementById('addLanguageIcon').addEventListener('click', function() {
    $('#Save').prop("disabled", false);
    var languageContainer = document.getElementById('languageContainer');
    var newLanguageBox = document.createElement('div');
    newLanguageBox.classList.add('language-box');
    newLanguageBox.innerHTML = `
        <div class="language">
            <h5>Language:</h5>
            <select id="lang" class="language-input" required name="language" >
                <option value="" disabled>Select a language...</option>
                ${generateLanguageOptions()}
            </select>
            <h5>Proficiency:</h5>
            <select name="level" class="language-input">
                <option disabled selected>-  Proficiency -</option>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
            </select>
            <h5>Price:</h5>
            <input type="number" id="price" name="price" min="0" " step="0.5" style="width: 90px; height: 20px ;">
            
            <div id="price-error-message" style="color: red;"></div>

        </div>
    `;
    languageContainer.appendChild(newLanguageBox);
});

function generateLanguageOptions() {
    var languages = [
        "Afrikaans", "Albanian", "Arabic", "Armenian", "Basque", "Bengali", "Bulgarian", "Catalan", "Cambodian", "Chinese (Mandarin)",
        "Croatian", "Czech", "Danish", "Dutch", "English", "Estonian", "Fiji", "Finnish", "French", "Georgian", "German", "Greek",
        "Gujarati", "Hebrew", "Hindi", "Hungarian", "Icelandic", "Indonesian", "Irish", "Italian", "Japanese", "Javanese", "Korean",
        "Latin", "Latvian", "Lithuanian", "Macedonian", "Malay", "Malayalam", "Maltese", "Maori", "Marathi", "Mongolian", "Nepali",
        "Norwegian", "Persian", "Polish", "Portuguese", "Punjabi", "Quechua", "Romanian", "Russian", "Samoan", "Serbian", "Slovak",
        "Slovenian", "Spanish", "Swahili", "Swedish", "Tamil", "Tatar", "Telugu", "Thai", "Tibetan", "Tonga", "Turkish", "Ukrainian",
        "Urdu", "Uzbek", "Vietnamese", "Welsh", "Xhosa"
    ];

    return languages.map(language => `<option value="${language}">${language}</option>`).join('');
}

        



});




</script>


    </head>

    <body id="ProfileManage">
    <?php include("partnerHeaderFooter.php"); ?>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" id="myForm" enctype="multipart/form-data">
        <?php
        $sql = "SELECT * FROM `partner` WHERE partnerID = '" . $_SESSION['ID'] . "'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
        ?>
                    <div class="ManageProfileBody">

                        <div class="left">
                            <img src="<?php echo $row['photo']; ?>" id="img" alt="Personal photo" accept="image/*">
                            <label id="personal-picLabel" for="personal-pic">Update image</label>
                            <input type="file" name="personal-pic" id="personal-pic">
                            <div id="imgError"></div>

                            <div class="button-container2">
                                <button class="accept" type="submit" name="submit" id="Save" disabled>Save Edit</button>
                                <button class="reject" onclick="window.location.href='partner-Profile.php'; return false;">Cancel Edit</button>
                            </div>
                        </div>

                        <div class="right">
                            <h3>Edit Profile</h3>
                            <div class="info_data">
                                <div class="data">
                                    <h4>First name</h4>
                                    <input type="text" name="firstName" id="firstName" value="<?php echo $row['firstName']; ?>" placeholder="Enter First Name">
                                    <div id="firstNameError"></div>

                                    <h4>Age</h4>
                                    <input type="number" min="15" name="age" id="age" value="<?php echo $row['age']; ?>">

                                    <h4>Email</h4>
                                    <input type="text" name="email" id="email" value="<?php echo $row['email']; ?>" placeholder="Enter Email">
                                    <div id="emailError"></div>

                                    <h4>Password</h4>
                                    <input type="password" placeholder="**********" minlength="8" maxlength="16" name="password" id="password">
                                    <div id="passwordError"></div>

                                    <h4>City</h4>
                                    <select name = "city" id="city">
                                <option disabled>- Select a city -</option>
                                <option value="Riyadh" <?php if($row['city'] == 'Riyadh') echo 'selected'; ?>>Riyadh</option>
                                <option value="Makkah" <?php if($row['city'] == 'Makkah') echo 'selected'; ?>>Makkah</option>
                                <option value="Madinah" <?php if($row['city'] == 'Madinah') echo 'selected'; ?>>Madinah</option>
                                <option value="Buraydah" <?php if($row['city'] == 'Buraydah') echo 'selected'; ?>>Buraydah</option>
                                <option value="Dammam" <?php if($row['city'] == 'Dammam') echo 'selected'; ?>>Dammam</option>
                                <option value="Abha" <?php if($row['city'] == 'Abha') echo 'selected'; ?>>Abha</option>
                                <option value="Tabuk" <?php if($row['city'] == 'Tabuk') echo 'selected'; ?>>Tabuk</option>
                                <option value="Hail" <?php if($row['city'] == 'Hail') echo 'selected'; ?>>Hail</option>
                                <option value="Arar" <?php if($row['city'] == 'Arar') echo 'selected'; ?>>Arar</option>
                                <option value="Jizan" <?php if($row['city'] == 'Jizan') echo 'selected'; ?>>Jizan</option>
                                <option value="Najran" <?php if($row['city'] == 'Najran') echo 'selected'; ?>>Najran</option>
                                <option value="Al-Baha" <?php if($row['city'] == 'Al-Bah') echo 'selected'; ?>>Al-Baha</option>
                                <option value="Sakaka" <?php if($row['city'] == 'Sakaka') echo 'selected'; ?>>Sakaka</option>
                                </select>
                                </div>

                                <div class="data">
                                    <h4>Last name</h4>
                                    <input type="text" name="lastName" id="lastName" value="<?php echo $row['lastName']; ?>" placeholder="Enter Last Name">
                                    <div id="lastNameError"></div>

                                    <h4>Gender</h4>
                                    <input name="gender" type="radio" <?php if ($row['gender'] == 'Female') echo 'checked'; ?> value="Female"> Female
                                    <input name="gender" type="radio" <?php if ($row['gender'] == 'Male') echo 'checked'; ?> value="Male"> Male

                                    <h4>Phone</h4>
                                    <input type="text" name="phone" value="<?php echo $row['phone']; ?>" placeholder="0556199919" maxlength="10" id="PhoneNumber">
                                    <div id="PhoneNumberError"></div>

                                    <h4>Bio</h4>
                                    <textarea id="bio" name="bio" rows="20" cols="30" ><?php echo $row['bio']; ?></textarea><div id="BioError"></div>
                                    <br><br><br><br>
                                    <input type="hidden" name="deletedLanguages" id="deletedLanguagesInput">
                                </div>
                        
                    </div>
        <?php
                }
            }
        }
        ?>
        <div id="languageContainer">
        <h3 style=" display: inline-block;">Teaching Services</h3> <i class="fas fa-plus-circle" id="addLanguageIcon"></i><br>
        <?php
        $sql = "SELECT * FROM `service` WHERE `partnerEmail` = '" . $_SESSION["email"] . "'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
        ?>
                    <div class="language-box">
                        <div class="language">
                            <i class="fas fa-trash delete-language" data-language-name="<?php echo $row['langugeName']; ?>"></i>
                            <h4><?php echo $row['langugeName']; ?></h4>
                            <h5>Proficiency:</h5>
                            <p><?php echo $row['level']; ?></p>
                            <h5>Price:</h5>
                            <p><?php echo $row['price']; ?>/hour</p>
                        </div>
                    </div>
        <?php
                }
            }
        }
        ?>
      
        </div>
            </div>
                </div>
    </form>
</body>

    
      </html>