<?php


// Start session
session_start();

// Database configuration
$host = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "lingohub";

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to retrieve all rates from the database
function get_all_rates()
{
    global $conn;

    // SQL query to retrieve all ratings, comments, learner names, and review date/time
    $sql = "SELECT r.rating, r.comment, r.posted_rate, r.learnerfname , learnLname
            FROM review AS r 
            JOIN learner AS l ON l.learnerID = r.sessionID";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error fetching rates: " . mysqli_error($conn));
    }

    return $result;
}

// Retrieve all rates from the database
$rates = get_all_rates();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rates and Reviews</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Assuming you have a custom CSS file -->
</head>
<body>
    <!-- Assuming you have a header and footer include files -->
    <?php include("partnerHeaderFooter.php"); ?>
    
    <div class="outerDiv">
        <?php
        // Loop through each rate retrieved from the database
        while ($row = mysqli_fetch_assoc($rates)) {
            echo '
                <div class="SubDiv">
                    <div class="innerDiv">
                    <img class="userImg" src="defultpic.jpg" alt="userImg">
                        <strong class="Reviewers">' . $row["learnerfname"] . ' ' . $row["learnLname"] . '</strong><br>
                        <p class="date">' . $row["posted_rate"] . '</p>';

            // Output star ratings based on the rating value
            for ($i = 1; $i <= $row["rating"]; $i++) {
                echo '<span class="fa fa-star checked"></span>';
            }

            echo '<p>' . $row["comment"] . '</p>
                    </div>
                </div>';
        }
        ?>
    </div>

    <!-- Assuming you have a footer include file -->
  

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
