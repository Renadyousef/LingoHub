<!-- Implement session and fix header and footer  -->


<?php
// Start the session to manage user state and interactions
session_start();

// Database connection setup
$host = "127.0.0.1";
$dbname = "lingohub";
$username = "root";
$password = "";
$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve session and partner IDs from query parameters, defaulting if not set
$sessionID = isset($_GET['sessionID']) ? $_GET['sessionID'] : 'DefaultSessionID';
$partnerID = isset($_GET['partnerID']) ? $_GET['partnerID'] : 'DefaultPartnerID';

// Prepare and execute a query to fetch partner information
$partnerQuery = "SELECT * FROM partner WHERE partnerID = ?";
$stmt = $conn->prepare($partnerQuery);
$stmt->bind_param("i", $partnerID);
$stmt->execute();
$partnerResult = $stmt->get_result();
$partner = $partnerResult->fetch_assoc();

// Handle POST requests for submitting reviews
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $learnerfname = $_POST['firstname'];
    $learnerlname = $_POST['lastname'];
    $rating = isset($_POST['rate']) ? $_POST['rate'] : 0;
    $comment = $_POST['comment'];

    $insertReviewQuery = "INSERT INTO review (sessionID, learnerfname, learnLname, partnerID, comment, rating, posted_rate) 
                          VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($insertReviewQuery);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }
    
    $stmt->bind_param("issisd", $sessionID, $learnerfname, $learnerlname, $partnerID, $comment, $rating);
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Review submitted successfully!";
        header("Location: LearnerViewPreviousSessions.php"); // Redirect after successful sub
        exit();
    }
}
$conn->close();?>





<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
    <title>Review and Rate</title>
     <style>#ratingFnameValidationMessage, #ratingCommentValidationMessage, #ratingLnameValidationMessage {
            font-size: smaller; 
            margin-bottom: 10px; 
            margin-left: 20px;}
    </style> 
</head>

<body>
<?php include("LearnerHeaderFooter.php"); ?>
    <div class="contentrate">
        <div class="image-container">
            <img src="<?php echo $partner['photo']; ?>" alt="Partner picture">
            <p>Partner</p>
            <span class="partner-reviewed"><?php echo $partner['firstName'] . ' ' . $partner['lastName']; ?></span>
        </div>
        <div class="form-container">
            <h2 id="h2session">Leave a Review</h2>
            <div class="redNote">Note: all fields with * are required</div>
            <form id="reviewForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?sessionID=' . $sessionID . '&partnerID=' . $partnerID; ?>">
                <div class="form-group">
                    <label for="fname" class="required">First Name:</label><br>
                    <input type="text" id="fname" name="firstname" required>
                </div>
                <div id="ratingFnameValidationMessage" ></div>

                <div class="form-group">
                    <label for="lname" class="required">Last Name:</label><br>
                    <input type="text" id="lname" name="lastname" required>
                </div>
                <div id="ratingLnameValidationMessage" ></div>

                <div class="form-group">
                    <label class="required">Rate the session:</label><br>
                    <div class="rate">
                        <input type="radio" id="star5" name="rate" value="5"><label for="star5">5 stars</label>
                        <input type="radio" id="star4" name="rate" value="4"><label for="star4">4 stars</label>
                        <input type="radio" id="star3" name="rate" value="3"><label for="star3">3 stars</label>
                        <input type="radio" id="star2" name="rate" value="2"><label for="star2">2 stars</label>
                        <input type="radio" id="star1" name="rate" value="1"><label for="star1">1 star</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>How was your experience? (Optional)</label><br>
                    <textarea id="comment" name="comment" placeholder="Tell us about it!"></textarea>
                </div>
                <div id="ratingCommentValidationMessage"></div>

                <div class="form-group">
                    <input type="submit" value="Submit" id="submit-btn">
                </div>
            </form>
        </div>
    </div>

       <!-- JavaScript for form validation and handling -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('reviewForm');
        const fname = document.getElementById('fname');
        const lname = document.getElementById('lname');
        const comment = document.getElementById('comment');

        // Focus and validation messages setup
        const focusMessages = {
            fname: "Enter your first name.",
            lname: "Enter your last name.",
            comment: "Share your experience here."
        };

        const ratingValidationMessages = {
            fname: "Please enter a single word containing letters only.",
            lname: "Please enter a single word containing letters only.",
            comment: "Please use only alphanumeric and basic punctuation."
        };

        // Handling form element focus events
        function handleFocus(event) {
            const id = event.target.id;
            const messageDiv = document.getElementById('rating' + id.charAt(0).toUpperCase() + id.slice(1) + 'ValidationMessage');
            messageDiv.textContent = focusMessages[id];
            messageDiv.style.color = "black"; // Default focus message color
        }

        // Handling form element blur events
        function handleBlur(event) {
            const id = event.target.id;
            const regex = id === 'fname' || id === 'lname' ? /^[A-Za-z]+$/ : /^[a-zA-Z0-9\s.,'-]*$/; // Allow empty comments
            const messageDiv = document.getElementById('rating' + id.charAt(0).toUpperCase() + id.slice(1) + 'ValidationMessage');
            if (event.target.value && !event.target.value.match(regex)) {
                event.target.classList.add('empty');
                messageDiv.textContent = ratingValidationMessages[id];
                messageDiv.style.color = "red"; // Error message color
            } else {
                event.target.classList.remove('empty');
                messageDiv.textContent = ''; // Clear message on valid input
            }
        }

        fname.addEventListener('focus', handleFocus);
        lname.addEventListener('focus', handleFocus);
        comment.addEventListener('focus', handleFocus);

        fname.addEventListener('blur', handleBlur);
        lname.addEventListener('blur', handleBlur);
        comment.addEventListener('blur', handleBlur);

        // Handling form submission events
        form.addEventListener('submit', function(event) {
            let isFormValid = true;

            const inputs = [fname, lname];
            inputs.forEach(input => {
                const blurEvent = new Event('blur');
                input.dispatchEvent(blurEvent);
                if (input.classList.contains('empty')) {
                    isFormValid = false;
                }
            });

            // Ensure a rating is selected
            const rates = document.querySelectorAll('input[name="rate"]');
            const rateSelected = Array.from(rates).some(rate => rate.checked);
            if (!rateSelected) {
                alert("Please select a star rating for the session.");
                isFormValid = false;
            }

            if (!isFormValid) {
                event.preventDefault();
                alert("Make sure all fields are correctly filled.");
            }
        });
    });
    </script>
</body>
</html>