<!-- Implement session and fix header and footer  -->

<?php
session_start(); 
/*
// Check if the partner is logged in
if (!isset($_SESSION['partner_id'])) {
    // Redirect the partner to the login page if they are not logged in
    header("Location: login.php");
    exit;}
*/
$partnerID = $_SESSION['ID']; // Assuming the partner ID is stored in the session variable 



// Initialize the database connection
$host = "127.0.0.1";
$dbname = "lingohub";
$username = "root";
$password = "";
$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// SQL query to fetch previous sessions along with learner and language details
//replace s.partnerID = 1 with s.partnerID ='$partnerID'
$query = "SELECT s.*, l.firstName, l.lastName, l.email, l.photo, g.LanguageCode
          FROM session s
          JOIN learner l ON s.learnerID = l.learnerID
          JOIN language g ON s.language = g.LanguageName
          WHERE (s.Date < CURDATE() OR 
                (s.Date = CURDATE() AND CURTIME() > ADDTIME(s.startTime, s.duration)))
          AND s.partnerID ='$partnerID'
          ORDER BY s.Date DESC, s.startTime DESC";


// Execute the query
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Sessions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
</head>

<body>
    <?php include("partnerHeaderFooter.php"); ?>
    <h2 id="h2session">Previous Sessions</h2>

    <div class="content">
    <?php if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()): ?>
        <div class="session-info">
            <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="Partner picture">
            <span class="<?php echo 'fi fi-' . strtolower($row['LanguageCode']); ?>"></span>

            <p>
                <span class="session-partner-label">Partner Name:</span>
                <span class="session-partner"><?php echo htmlspecialchars($row['firstName']) . ' ' . htmlspecialchars($row['lastName']); ?></span>
                <br>
                <span class="session-language-label">Language:</span>
                <span class="session-language"><?php echo htmlspecialchars($row['language']); ?></span>
                <br>
                <span class="session-date-label">Session Date:</span>
                <span class="session-date"><?php echo date('d/m/Y', strtotime($row['Date'])); ?></span>
                <br>
                <span class="session-time-label">Session Time:</span>
                <span class="session-time"><?php 
    $startTime = strtotime($row['startTime']);
    $durationInSeconds = strtotime($row['duration']) - strtotime('TODAY');
    $endTime = $startTime + $durationInSeconds;
    echo date('h:i A', $startTime) . ' - ' . date('h:i A', $endTime); 
?></span>                <br>
            </p>
            <div class="button-container1">
                <button class="contact" onclick="window.location.href='mailto:<?php echo htmlspecialchars($row['email']); ?>'">Contact</button>
            </div>

        </div>
        <?php endwhile; } else {
            echo "<p><br><br><br><br><br><br>No previous sessions available.</p>";
        } 
        $conn->close();?>
    </div>
</body>
</html>