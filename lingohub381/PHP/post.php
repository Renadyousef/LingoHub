<?php //posting request a learner to  a certian partner
session_start();//at every page we need to access session varibles start session
$learner_id =$_SESSION['ID']; //$_SESSION['learner_id'];//set it in the session please at login page
$partner_id =$_POST['ID']; //$_SESSION['partner_id'];//ig related to post to be to partner
//this page to validate input and sent it to db
//data base connection

if($database=mysqli_connect('localhost','root','')){


 //open data base

if (!mysqli_select_db($database, 'lingohub')) {
    die('There is an issue with selecting the database: ' . mysqli_error($database));
}

//now lets insert the posted request into the data base

//first validate input, the text input

//no need to validate
$lang=$_POST['language']; 
$proficiency_level=$_POST['proficiency'];
//**************************************************************************** 
//now date and time validted in front end
$date=$_POST['scheduleDate'];
$time=$_POST['scheduleTime']; //in db its a one col type is date time

$datetime_str = $date.' '.$time; //combine them

//converting it into an object
$datetime = new DateTime($datetime_str);

//format for MySQL datetime field
$formatted_date= $datetime->format('Y-m-d H:i:s');
/*
src for format method use to be changed to data base datetime formst!
https://www.php.net/manual/en/datetime.format.php
*/

//****************************************************************************** 

$duration = $_POST['Session_duration'];


//comments we defnitlay need to validate this since its a text 
$comments=$_POST['comments'];

//validate comments to be inserted into db and xss issues
$comments=htmlspecialchars(mysqli_real_escape_string($database,$comments));

//query 
//the state by default is pending in db i think it will not be changed in my page for  now 
//? +the  RequestID genrated auto ing db so no need to add it+ learnerID coming from session?
$query="INSERT INTO request(LanguageName, learnerID, partnerID, level, preferredSchedule, sessionDuration, comment)
VALUES('$lang',$learner_id,$partner_id,'$proficiency_level','$formatted_date','$duration','$comments');";

//no need to habdle posted_time its set with a function
//close connection

if(!(mysqli_query($database,$query))){
    die( 'theres an issue when query excute'.mysqli_error($database));
}else{
    // Redirect to the learner request page
    header("Location: ../Html/partnerList.php");
    
}
//after query
mysqli_close($database);



}else
die( 'can not connect data base'.mysqli_error($database));




