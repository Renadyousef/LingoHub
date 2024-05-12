<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>homepage Learner</title>
        <link href="../css/styles.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
       
    </head>
   
    <body>
    <?php include("LearnerHeaderFooter.php"); ?>
        <div id ="contentOfLearner"> 
        <?php 
            session_start();
            if(isset($_SESSION['firstName'])) {
                $firstName = $_SESSION['firstName'];
            } else {
                $firstName = "Guest";
            }
        ?>
        <h1 class="Slogan">Hello <?php echo $firstName; ?>!</h1>
            <h4 class="Slogantext"> make your free time valuable! </h4>
            </div>
    
           
    </body>
   
</html>