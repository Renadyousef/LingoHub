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
    $password = $_POST['password'];
    $location = $_POST['location'];
    if(isset($_FILES['personal-pic']) && $_FILES['personal-pic']['error'] === UPLOAD_ERR_OK) {
      // Handle file upload
      $photo = $_FILES['personal-pic']['name'];
      $targetDir = __DIR__ . "/"; // Specify your target directory
      $targetFile = $targetDir . basename($_FILES["personal-pic"]["name"]);
      move_uploaded_file($_FILES["personal-pic"]["tmp_name"], $targetFile);
     
    } 
  else{
   $photo = isset($_POST['personal-pic']) && $_POST['personal-pic'] !== "" ? $_POST['personal-pic'] :""; }
   
    $sql = "INSERT INTO `learner`(`firstName`, `lastName`, `email`, `password`, `city`, `photo`, `location`) VALUES ('$fname', '$lname', '$email','$password', '$city', '$photo', '$location')";
    $res= mysqli_query($connection, $sql);

  if ($res) {
    // All services inserted successfully
    echo '<script>alert("Registration successful!!");window.location.href="login.php";</script>';
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
        var fileInput = $('#imgfile')[0]; // Access the file input element
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
    function validateLocation() {
    var location = $('#location').val();
    // Regular expression for validating location: Neighborhood-Street format
    var locationRegex1 = /^[A-Za-z0-9\s]+ , [A-Za-z0-9\s]+$/;
    var locationRegex2 = /^[A-Za-z0-9\s]+,[A-Za-z0-9\s]+$/;
    if (locationRegex1.test(location) ||locationRegex2.test(location) ) {
        isLocationValid = true;
        $('#locationError').text("");
    } else {
        isLocationValid = false;
        $('#locationError').text("Please enter a valid location in the format: Neighborhood , Street").css({ "color": "red", "font-size": "12px" });
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
    $('#imgfile').on('change', validateImage);
    $('#location').on('input', validateLocation);
    
   
    

    $("#myForm").submit(function(event) {
        if (($('#firstName').val() === "" || $('#lastName').val() ==="" ||  $('#email').val() === "" || $('#password').val() === "") ){
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


                    
                        <label>Location</label>
                        <div class="input-fieldSinup">
                        <input type = "text" name = "location" id= "location" placeholder="Enter your loaction ">
                        </div>  <div id="locationError" ></div>

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

                       
                        

                      
                       
                    </div>
            
                      
                 
                
                </div>
               
           
                <input type="submit" name="submit" id="Save" value="Sign Up" class="btn">
            </form>
        </div>
    </div>
</body>
</html>