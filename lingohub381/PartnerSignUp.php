<!DOCTYPE html>
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
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    if (isset($_POST["Gender"]))
    $gender = $_POST["Gender"];
else
    $gender = "";
    $age = $_POST['age'];
    $password = $_POST['password'];
    $bio = $_POST['bio'];
    $phone=$_POST['phone'];
    $lang = $_POST['language'];$pro = $_POST['proficiency'];$price = $_POST['price'];
    if(isset($_FILES['personal-pic']) && $_FILES['personal-pic']['error'] === UPLOAD_ERR_OK) {
      // Handle file upload
      $photo = $_FILES['personal-pic']['name'];
      $targetDir = __DIR__ . "/"; // Specify your target directory
      $targetFile = $targetDir . basename($_FILES["personal-pic"]["name"]);
      move_uploaded_file($_FILES["personal-pic"]["tmp_name"], $targetFile);
  } else {
      // If no file is uploaded or an error occurred
      $photo = isset($_POST['personal-pic']) && $_POST['personal-pic'] !== "" ? $_POST['personal-pic'] :""; 
  }


   
  $sql = "INSERT INTO `partner`(`firstName`, `lastName`, `email`, `phone`, `password`, `city`, `photo`, `bio`, `gender`, `age`) VALUES ('$fname', '$lname', '$email', '$phone', '$password', '$city', '$photo', '$bio', '$gender', $age)";
  $res= mysqli_query($connection, $sql);

  if ($res) {
    // Rest of the code
    $partnerEmail = $email; 
    // Loop through submitted services
    for ($i = 0; $i < count($_POST['language']); $i++) {
        $lang = $_POST['language'][$i];
        $pro = $_POST['proficiency'][$i];
        $price = $_POST['price'][$i];

        // Insert service into service table
        $sqlS = "INSERT INTO `service`(`partnerEmail`, `langugeName`, `level`, `price`) VALUES ('$partnerEmail','$lang','$pro','$price')";
        $res2 = mysqli_query($connection, $sqlS);

        // Check if service insertion was successful
        if (!$res2) {
            // Handle insertion failure
            echo "Error inserting service: " . mysqli_error($connection);
            exit; // Exit the loop and script if any service insertion fails
        }
    }

    // All services inserted successfully
    echo '<script>alert("Registration successful!!");window.location.href="index.php";</script>';
    exit;
} else {
    // Handle partner insertion failure
    echo "Error inserting partner: " . mysqli_error($connection);
}
    
  
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" /> 
    <title>sign Up</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
$(document).ready(function (){
   var isFnameValid = true;
   var isLnameValid = true;
   var isEmailValid = true;
   var isPasswordValid = true;
   var isImgValid = true;
   var isPhoneValid = true;
   var isvalidBio=true;

   function validateFirstName() {
        var firstName = $('#firstName').val();
        // Regular expression for validating first name: At least 2 alphabetic characters
        var firstNameRegex = /^[A-Za-z]{2,}$/;
        if (firstNameRegex.test(firstName) ) {
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
        if (lastNameRegex.test(lastName)) {
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
    if (emailRegex.test(email)) {
        $.ajax({
            url: "../PHP/checkP_email.php",
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
    } else if (emailRegex.test(email)) {
    $.ajax({
        url: "../PHP/checkL_email.php", // Update the URL here
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
}
else{
        isEmailValid = false;
        $('#emailError').html("Please enter a valid email address<br> in this format localpart@domain.com .").css({ "color": "red", "font-size": "12px" });
        enableSaveButton();
    }
}
  
function validateUserPassword() {
    var passwordInput = $("#password").val();
    // Regular expression for validating passwords
    var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    if (passwordRegex.test(passwordInput)) {
        $('#passwordError').text(""); // Clear the error message if password is valid
        isPasswordValid = true;
    } else {
        $('#passwordError').html("Your password needs to be:<br>- at least 8 characters<br>- include both lowercase and uppercase letters<br>- include at least one number.").css({ "color": "red","font-size": "12px"});
        isPasswordValid = false;
    }
    enableSaveButton(); // Ensure to enable/disable the save button based on password validity
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

    if (phoneRegex.test(phone)) {
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
        if ((isFnameValid && isLnameValid && isEmailValid && isPasswordValid && isImgValid)) {
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
    $('#PhoneNumber').on('input', validatePhoneNumber);
    $('#bio').on('input', validateBio);
   
    

    $("#myForm").submit(function(event) {
        if (($('#firstName').val() === "" || $('#lastName').val() ==="" ||  $('#email').val() === "" || $('#password').val() === ""|| $('#PhoneNumber').val() === "")) {
        event.preventDefault();
        }    

    });
});



</script>
<style>
        .required-label::after {
            content: "*";
            color: red;
            margin-right: 5px;
        }
        .select_container2 {
        display: flex;
    justify-content: center;
    position: relative;
    width: 140px;
    height: 30px;
    background: #f0f0f0;
        }
        .form-row {
    display: flex;
    justify-content: space-between; /* Adjust spacing between columns */
    
}

.form-col {
    flex: 1; /* Each column takes up equal space */
    margin-right: 10px; /* Adjust margin between columns */
}
.containersign {
    overflow-y: scroll;
    position: relative; /* Ensure the pseudo-element is positioned relative to this container */
}

.containersign::before {
    content: "";
  position: absolute;
  top: 0;
  left: -50%;
    width: 125%;
  height: 100%;
  background:linear-gradient(120deg, #7C93C3, #9eb8d9,#EEF5FF);
  z-index: 6;
  transform: translateX(100%);
  transition: 1s ease-in-out;
  
}
.containersign {
  
    height: 535px;}

    .containersign::before { 
  width: 130%;
  }
    </style>
      
      <script>
  function addLanguage() {
    var formRow = document.createElement('div');
    formRow.className = 'form-row';

    var languageDiv = document.createElement('div');
    languageDiv.className = 'form-col';

    var languageLabel = document.createElement('label');
    languageLabel.className = 'required-label';
    languageLabel.setAttribute('for', 'language');
    languageLabel.innerText = 'Language';

    var languageSelectContainer = document.createElement('div');
    languageSelectContainer.className = 'select_container2';

    var languageSelect = document.createElement('select');
    languageSelect.name = 'language[]';
    languageSelect.id = 'language';
    languageSelect.className = 'select_box';
    languageSelect.required = true;

    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.disabled = true;
    defaultOption.innerText = 'Select a language...';
    languageSelect.appendChild(defaultOption);

    // Adding language options dynamically
    var languages = ["Afrikaans", "Albanian", "Arabic", "Armenian", "Basque", "Bengali", "Bulgarian", "Catalan", "Cambodian", "Chinese (Mandarin)", "Croatian", "Czech", "Danish", "Dutch", "English", "Estonian", "Fiji", "Finnish", "French"];

    languages.forEach(function(language) {
        var option = document.createElement('option');
        option.value = language;
        option.innerText = language;
        languageSelect.appendChild(option);
    });

    languageSelectContainer.appendChild(languageSelect);
    languageDiv.appendChild(languageLabel);
    languageDiv.appendChild(languageSelectContainer);

    var proficiencyDiv = document.createElement('div');
    proficiencyDiv.className = 'form-col';

    var proficiencyLabel = document.createElement('label');
    proficiencyLabel.className = 'required-label';
    proficiencyLabel.setAttribute('for', 'proficiency');
    proficiencyLabel.innerText = 'Proficiency Level';

    var proficiencySelectContainer = document.createElement('div');
    proficiencySelectContainer.className = 'select_container2';

    var proficiencySelect = document.createElement('select');
    proficiencySelect.name = 'proficiency[]';
    proficiencySelect.id = 'proficiency';
    proficiencySelect.className = 'select_box';
    proficiencySelect.required = true;

    var proficiencyDefaultOption = document.createElement('option');
    proficiencyDefaultOption.value = '';
    proficiencyDefaultOption.disabled = true;
    proficiencyDefaultOption.innerText = 'Select a level';
    proficiencySelect.appendChild(proficiencyDefaultOption);

    // Adding proficiency level options dynamically
    var proficiencyLevels = ["Beginner", "Intermediate", "Advanced"];
    proficiencyLevels.forEach(function(level) {
        var option = document.createElement('option');
        option.value = level;
        option.innerText = level;
        proficiencySelect.appendChild(option);
    });

    proficiencySelectContainer.appendChild(proficiencySelect);
    proficiencyDiv.appendChild(proficiencyLabel);
    proficiencyDiv.appendChild(proficiencySelectContainer);

    var priceDiv = document.createElement('div');
    priceDiv.className = 'form-col';

    var priceLabel = document.createElement('label');
    priceLabel.className = 'required-label';
    priceLabel.setAttribute('for', 'price');
    priceLabel.innerText = 'Price SR/HR';

    var priceSelectContainer = document.createElement('div');
    priceSelectContainer.className = 'select_container2';

    var priceSelect = document.createElement('select');
    priceSelect.name = 'price[]';
    priceSelect.id = 'price';
    priceSelect.className = 'select_box';
    priceSelect.required = true;

    var priceDefaultOption = document.createElement('option');
    priceDefaultOption.value = '';
    priceDefaultOption.disabled = true;
    priceDefaultOption.innerText = 'Select a price';
    priceSelect.appendChild(priceDefaultOption);

    // Adding price options dynamically
    var prices = ["200", "250", "300", "350", "400", "450", "500"];
    prices.forEach(function(price) {
        var option = document.createElement('option');
        option.value = price;
        option.innerText = price;
        priceSelect.appendChild(option);
    });

    priceSelectContainer.appendChild(priceSelect);
    priceDiv.appendChild(priceLabel);
    priceDiv.appendChild(priceSelectContainer);

    formRow.appendChild(languageDiv);
    formRow.appendChild(proficiencyDiv);
    formRow.appendChild(priceDiv);

    // Get reference to the Save button
    var saveButton = document.getElementById('Save');
    // Insert the new form row before the Save button
    saveButton.parentNode.insertBefore(formRow, saveButton);
}

</script>


</head>

<body id="loginbody">
    <div class="containersign"  >
        <div class="signin-signup" >
            <form id="myForm" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" class="sign-in-form">
                <h2 class="title">Sign Up</h2>
                <?php if (!empty($notification)) { ?>
                    <div class="notification"><?php echo $notification; ?></div>
                <?php } ?>
                <div class="info_data">
                    <div class="data">
                        <label class="required-label">First name</label>
                        <div class="input-fieldSinup">
                            <input type="text" placeholder="Enter First name" name="firstName" id="firstName" required>
                        </div><div id="firstNameError"></div>

                        <label class="required-label">Age</label>
                        <div class="input-fieldSinup">
                            <input type="number" placeholder="Enter your age" name="age" id="age" min="15" required>
                        </div>

                        <label class="required-label">Email</label>
                        <div class="input-fieldSinup">
                            <input type="email" placeholder="Enter your email" name="email" id="email" required>
                        </div> <div id="emailError"></div>

                        <label class="required-label">Password</label>
                        <div class="input-fieldSinup">
                            <input type="password" name="password" id="password" placeholder="Enter new password" minlength="8" required>
                        </div><div id="passwordError"></div>

                        <label>Personal photo</label>
                        <input type="file" name="personal-pic" id="imgfile" class="photo" accept="image/*">
                        <div id="imgError"></div>
                    
                    </div>
                  
                    <div class="data">
                        <label>Last name</label>
                        <div class="input-fieldSinup">
                            <input type="text" id="lastName" name="lastName" placeholder="Enter last name">
                        </div> <div id="lastNameError"></div>


                        <label class="required-label">Phone</label>
                        <div class="input-fieldSinup">
                            <input type="text" id="PhoneNumber" name="phone" value="" placeholder="Enter your phone" maxlength="10" required>
                        </div><div id="PhoneNumberError"></div>

                        <label id="grand_label" value="" class="required-label">Gender</label><br>
                        <div class="radio_button">
                            <input type="radio" id="radio_button" name="Gender" value="Male"  required><label>Male</label>
                        </div>

                        <div class="radio_button">
                            <input type="radio" id="radio_button" name="Gender" value="Female" required><label>Female</label>
                        </div>
                        <br><div id="gender"></div>

                        <label>City</label>
                        <div class="select_container">
                            <select name="city" id="city" class="select_box">
                                <option disabled>- Select a city -</option>
                                <option selected>Riyadh</option>
                                <option>Makkah</option>
                                <option>Madinah</option>
                                <option>Buraydah</option>
                                <option>Dammam</option>
                                <option>Abha</option>
                                <option>Tabuk</option>
                                <option>Hail</option>
                                <option>Arar</option>
                                <option>Jizan</option>
                                <option>Najran</option>
                                <option>Al-Baha</option>
                                <option>Sakaka</option>
                            </select>
                        </div>

                        <div class="textarea_field">
                            <label>Bio</label>
                            <p><textarea id="bio" name="bio" rows="5" cols="10" placeholder="Such as, languages spoken and cultural knowledge ... etc."></textarea></p>
                        </div>
                        

                      
                       
                    </div>
            
                      
                 
                
                </div>
                 <div class="form-row">
                <div class="form-col">
                    <label class="required-label" for="language">Language</label>
                    <div class="select_container2">
                        <select name="language[]" id="language" class="select_box" required>
                            <option value="" disabled>Select a language...</option>
                            <?php
                            // Retrieve language from language table to make sure that he selects language from the table
                            $sql = "SELECT `LanguageName` FROM `language`";
                            $result = mysqli_query($connection, $sql);

                            // Check if the query was successful
                            if ($result) {
                                // Fetch all language names into an array
                                $languages = mysqli_fetch_all($result, MYSQLI_ASSOC);

                                // Free the result set
                                mysqli_free_result($result);

                                // Output options
                                foreach ($languages as $language) {
                                    echo '<option value="' . $language['LanguageName'] . '">' . $language['LanguageName'] . '</option>';
                                }
                            } else {
                                // Handle the case where the query failed
                                echo "Error: " . mysqli_error($connection);
                            }
                            ?>
                        </select>
                    </div>
                    <a id="addServiceLink" href="#" onclick="addLanguage()" style="text-decoration: underline; font-size: smaller;">Add Another Service</a>
                </div>
                <div class="form-col">
                    <label class="required-label" for="proficiency">Proficiency Level</label>
                    <div class="select_container2">
                        <select name="proficiency[]" id="proficiency" class="select_box" required>
                            <option value="" disabled>Select a level</option>
                            <option>Beginner</option>
                            <option>Intermediate</option>
                            <option>Advanced</option>
                            <!-- Add your proficiency level options here -->
                        </select>
                    </div>
                </div>
                <div class="form-col">
                    <label class="required-label" for="price">Price SR/HR</label>
                    <div class="select_container2">
                        <select name="price[]" id="price" class="select_box" required>
                            <option value="" disabled>Select a price</option>
                            <option>200</option>
                            <option>250</option>
                            <option>300</option>
                            <option>350</option>
                            <option>400</option>
                            <option>450</option>
                            <option>500</option>
                            <!-- Add your price options here -->
                        </select>
                    </div>
                </div>
            </div>
           
                <input type="submit" name="submit" id="Save" value="Sign Up" class="btn">
            </form>
        </div>
    </div>
</body>
</html>