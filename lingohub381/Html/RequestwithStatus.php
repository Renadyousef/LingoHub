<!DOCTYPE html>
<?php 
      
      session_start();
      $host = "127.0.0.1";
      $username = "root";
      $password = "";
      $dbname = "lingohub";

      // Create connection
      $conn = mysqli_connect($host, $username, $password, $dbname);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View My Request With Their Status</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include("partnerHeaderFooter.php"); ?>
        
    <h2 id="h2session">My Requests With Their Status</h2>

    <table class="tableReq">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Language</th>
                <th>Date And Time</th>
               
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
         
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $query = "SELECT r.* 
            FROM request AS r
            JOIN session AS s ON r.partnerID = s.partnerID";
            $request = mysqli_query($conn, $query);
            $count = 1;

            if ($request) {
                while ($row = mysqli_fetch_assoc($request)) {
                    $learnerID = $row['learnerID'];
        $nameQuery = "SELECT firstName, lastName FROM learner WHERE learnerID = $learnerID";
        $nameResult = mysqli_query($conn, $nameQuery);
        
        if ($nameResult && $nameRow = mysqli_fetch_assoc($nameResult)) {
          $name = $nameRow['firstName'] . ' ' . $nameRow['lastName'];
          
          echo '<tr>
                  <td>' . $count . '</td>
                  <td>' . $name . '</td>
                  <td>' . $row["LanguageName"] . '</td>
                           
                            <td>' . $row["post_time"] .'</td>';
                            
                     // Output the status column with appropriate class based on status value
          if (strtolower($row["status"]) == "accepted") {
            echo '<td class="Green">' . $row["status"] . '</td>';
        } elseif (strtolower($row["status"]) == "pending") {
            echo '<td class="Gray">' . $row["status"] . '</td>';
        } elseif (strtolower($row["status"]) == "rejected") {
            echo '<td class="Red">' . $row["status"] . '</td>';
        } else {
            echo '<td>' . $row["status"] . '</td>'; // Default case (no specific class)
        }
    
        echo '</tr>';
        $count++;
    }}
    
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            // Function to determine status color class
            function getStatusClass($status) {
                switch (strtolower($status)) {
                    case "accepted":
                        return "Green";
                    case "pending":
                        return "Gray";
                    case "rejected":
                        return "Red";
                    default:
                        return "";
                }
            }

            // Close database connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>

</html>
