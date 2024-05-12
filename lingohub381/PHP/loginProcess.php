
<?php
session_start();

if(isset($_POST['submit'])){
    $servername= "localhost";
    $username= "root";
    $password= "";
    $dbname= "lingohub";
    
    $connection= mysqli_connect($servername, $username, $password, $dbname);
    $database= mysqli_select_db($connection, $dbname);

    // Check the connection
    if (!$connection) 
        die("Connection failed: " . mysqli_connect_error());

    if(!empty($_POST['uEmail']) && !empty($_POST['pass'])){
        $userEmail = mysqli_real_escape_string($connection, strip_tags($_POST['uEmail']));
        $userPassword = mysqli_real_escape_string($connection, $_POST['pass']);
        
        // Check in learner table
        $sql = "SELECT * FROM `learner` WHERE email='$userEmail' AND password='$userPassword'";
        $userFound = mysqli_query($connection, $sql);
        
        if($userFound){
            if(mysqli_num_rows($userFound) > 0){
                $row = mysqli_fetch_assoc($userFound);
                $_SESSION['ID'] = $row['learnerID'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['firstName'] = $row['firstName'];
                $_SESSION['lastName'] = $row['lastName'];
                $_SESSION['photo'] = $row['photo'];
                $_SESSION['password'] =$row['password'];
                header('Location: /lingohub381/Html/leanerhome.php');

                exit;
            }
        }

        // Check in partner table
        $sql = "SELECT * FROM `partner` WHERE email='$userEmail' AND password='$userPassword'";
        $userFound = mysqli_query($connection, $sql);
        
        if($userFound){
            if(mysqli_num_rows($userFound) > 0){
                $row = mysqli_fetch_assoc($userFound);
                $_SESSION['ID'] = $row['partnerID'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['firstName'] = $row['firstName'];
                $_SESSION['lastName'] = $row['lastName'];
                $_SESSION['photo'] = $row['photo'];
                $_SESSION['city'] = $row['city'];
                $_SESSION['password']=$row['password'];
                header('Location: /lingohub381/Html/Partnerhome.php');
                exit;
            }
        }
        
        // Redirect with error message if user not found or password is incorrect
        header('Location: ../index.php?error=failToLogIn');
        exit;
    }
}?>  

