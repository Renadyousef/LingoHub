<?php
session_start();
DEFINE ("servername","localhost");
DEFINE ("username","root");
DEFINE ("password","");
DEFINE("dbname","lingohub");
if (!$connection=mysqli_connect(servername,username,password)) 
    die("Connection failed: " . mysqli_connect_error());

if(!$database= mysqli_select_db($connection, dbname))
   die("Could not Open the " . dbname ."database" );

   if(isset($_POST['submit'])) {
      $fname = '';
      $lname = '';
      $email = '';
      $city = '';
      $location = '';
      $password = '';
      $photo='';
  
      // Fetching existing learner data from the database
      $sql = "SELECT * FROM `learner` WHERE learnerID ='" . $_SESSION["ID"] . "'";
      $results = mysqli_query($connection, $sql);
      if($results && mysqli_num_rows($results) > 0) {
          $row = mysqli_fetch_array($results);
  
          // Updating variables with form data or existing data if form data is not provided
          $fname = isset($_POST['firstName']) && $_POST['firstName'] !== "" ? $_POST['firstName'] : $row['firstName'];
          $lname = isset($_POST['lastName']) && $_POST['lastName'] !== "" ? $_POST['lastName'] : $row['lastName'];
          $email = isset($_POST['email']) && $_POST['email'] !== "" ? $_POST['email'] : $row['email'];
          $city = isset($_POST['city']) && $_POST['city'] !== "" ? $_POST['city'] : $row['city'];
          $location = isset($_POST['location']) && $_POST['location'] !== "" ? $_POST['location'] : $row['location'];
          $password = isset($_POST['password']) && $_POST['password'] !== "" ? mysqli_real_escape_string($connection, $_POST['password']) : $row['password'];
          $photo=isset($_POST['personal-pic']) && $_POST['personal-pic'] !== "" ? $_POST['personal-pic'] : $row['photo'];
          
          if(isset($_FILES['personal-pic']) && $_FILES['personal-pic']['error'] === UPLOAD_ERR_OK) {
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
      
      $sql = "UPDATE `learner` SET `firstName`='$fname', `lastName`='$lname', `email`='$email', `password`='$password', `location`='$location', `city`='$city', `photo`='$photo' WHERE learnerID =" . $_SESSION["ID"];

      $res = mysqli_query($connection, $sql);
  
      if($res) {
          echo '<script>alert("Your edits have been sent successfully!");window.location.href="learner-Editeprofile.php";</script>';
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
        <title>My Profile</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="../css/styles.css" type="text/css" rel="stylesheet">

<style>

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function () {
   var isFnameValid = true;
   var isLnameValid = true;
   var isEmailValid = true;
   var isPasswordValid = true;
   var isImgValid = true;
   var isLocationValid = true;
   var ischangeCiti=false;

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
            url: "checkL_email.php",
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
    function validateLocation() {
    var location = $('#location').val();
    // Regular expression for validating location: Neighborhood-Street format
    var locationRegex1 = /^[A-Za-z0-9\s]+ , [A-Za-z0-9\s]+$/;
    var locationRegex2 = /^[A-Za-z0-9\s]+,[A-Za-z0-9\s]+$/;
    if (locationRegex1.test(location) || location === ""||locationRegex2.test(location) ) {
        isLocationValid = true;
        $('#locationError').text("");
    } else {
        isLocationValid = false;
        $('#locationError').text("Please enter a valid location in the format: Neighborhood , Street").css({ "color": "red", "font-size": "12px" });
    }
    enableSaveButton();
}








    function enableSaveButton() {
        if ((isFnameValid && isLnameValid && isEmailValid && isPasswordValid && isImgValid&&isLocationValid)) {
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
    $('#location').on('input', validateLocation);
    $('#city').on('change', function () {
        ischangeCiti=true; 
        enableSaveButton(); });

    $("#myForm").submit(function(event) {
        if (($('#firstName').val() === "" && $('#lastName').val() ==="" &&  $('#email').val() === "" && $('#password').val() === "" && $('#location').val() === "" && ischangeCiti === false)) {
        event.preventDefault();
        }else
        var confirmSubmit = window.confirm("Are you sure you want to save the changes?");
        if (!confirmSubmit ) {
             event.preventDefault();
           }

    });
});


</script>
</head>
<body id = "ProfileManage">
    <?php include("LearnerHeaderFooter.php"); ?>


    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" id="myForm" enctype="multipart/form-data">

<?php
   $sql = "SELECT * FROM `learner` WHERE learnerID ='" . $_SESSION["ID"] . "'";
   $resuslt = mysqli_query($connection,$sql);
   if($resuslt){
      if(mysqli_num_rows($resuslt)>0){
          while($row = mysqli_fetch_array($resuslt)){
?>

 <div class ="ManageProfileBody" >
        <div class="left">
            <img  src="<?php echo $row['photo']; ?>" id="img" alt="Personal photo">   
            <label id="personal-picLabel" for="personal-pic">update image</label>
            <input type="file" name="personal-pic"  id="personal-pic"><div id="imgError"></div>
            
         </div>

        <div class="right">
                       
                        <h3>Edit Profile</h3>
                     <div class="info_data">
                        <div class="data">
                            <h4>First name</h4> 
                            <input type = "text" name="firstName" id="firstName"  value="<?php echo $row['firstName']; ?>" placeholder="Enter First Name"><div id="firstNameError"></div>
                            <h4>Email</h4> 
                            <input type = "text" name="email" id="email" value="<?php echo $row['email']; ?>" placeholder="Enter Email"><div id="emailError"></div>
                            <h4>city</h4> 
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
                         <div class="data" >
                            <h4>Last name</h4>
                            <input type = "text" name="lastName" id="lastName"  value="<?php echo $row['lastName']; ?>" placeholder="Enter Last Name"><div id="lastNameError" ></div>
                            <h4>Password</h4> 
                            <input type = "password" placeholder="**********"  minlength="8" maxlength="16" name="password" id="password"><div id="passwordError" ></div>
                            <h4>Location</h4> 
                            <input type="text" name="location"  maxlength="20" id="location" value="<?php echo $row['location']; ?>" placeholder="Enter location"><div id="locationError" ></div>
                         </div>

                           


                    </div>
                    <br><br><br><br><br><br>
                    <div class="button-container2">
                        <button class="accept" type="submit" name="submit" id="Save" disabled >Save Edit</button>
                        <button class="reject" onclick="window.location.href='learner-profile.php'; return false;">Cancel Edit</button>

                    </div> 
                   
         </div>
         <!--End of class "right" -->

 </div><!--End of class "ManageProfileBody" -->
 <?php }}} ?>
 </form>
    
    </body>

      </html>
