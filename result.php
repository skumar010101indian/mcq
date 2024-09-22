<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mcq_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the table name and user answers
$table_name = $_POST['table_name'];
$score = 0;
$total_questions = 0;

// Fetch correct answers from the database
$sql = "SELECT * FROM $table_name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_questions++;
        $user_answer = $_POST['q' . ($total_questions - 1)];

        // Check if user answer is correct
        if ($user_answer == $row['correct_option']) {
            $score++;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Result</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Your Test Result</h2>
    <p>You scored <?php echo $score; ?> out of <?php echo $total_questions; ?>.</p>
    <a href="test.php">Take another test</a> <!-- Link back to the test selection page -->
</body>
</html>
