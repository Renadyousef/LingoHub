<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" /> 
    <title>sign in</title>
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
</head>
    


<body id="loginbody">
    <div class="containersign">
        <div class="signin-signup">
            <form action="../PHP/loginProcess.php" class="sign-in-form" method="post">

                <h2 class="title">Sign in</h2>
                <p >Welcome back! Please sign in to your account.</p>
                <?php  if(isset($_GET['error'])){

if($_GET['error'] == 'failToLogIn'){
    ?>
    <div class="alert alert-danger" style="color:red;" role="alert">
    Wrong email/password, Try Again!
</div>
    <!--<small class="in-log-in">Please Enter correct email and password</small>-->
    
<?php
}}?>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="uEmail" placeholder="Email" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="pass" placeholder="Password" required>
                </div>
                <input type="submit" name="submit" value="Login" class="btn">
            </form>
             
        
        </div> 
        <div class="panels-container">
            <div class="panel right-panel">
                <div class="signup-option">
                <h2 class="dont have acco">Join Us!</h2>
                  <p class="signup-for">
                     <a href="LearnerSignUp.php" id="singup-login">sign up</a>  As Learner
                  </p>
                  <p class="signup-for">
                      <a href="PartnerSignUp.php" id="singup-login" >sign up</a>  As Partner
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>