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

// Fetch available question tables
$tables_sql = "SHOW TABLES LIKE 'questions_%'";
$tables_result = $conn->query($tables_sql);
$tables = [];

if ($tables_result->num_rows > 0) {
    while ($row = $tables_result->fetch_array()) {
        $tables[] = $row[0];
    }
}

// Fetch questions based on selected table
$questions = [];
if (isset($_POST['table_name'])) {
    $table_name = $_POST['table_name'];
    $sql = "SELECT * FROM $table_name";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
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
    <title>MCQ Test</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Select a Test</h2>
    <form id="selectTestForm" action="" method="POST">
        <label for="table_name">Choose a test:</label>
        <select name="table_name" id="table_name" required>
            <option value="">Select a test</option>
            <?php foreach ($tables as $table): ?>
                <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Load Test</button>
    </form>

    <?php if (!empty($questions)): ?>
        <h2>MCQ Test - <?php echo htmlspecialchars($table_name); ?></h2>
        <form id="mcqForm" action="result.php" method="POST">
    <input type="hidden" name="table_name" value="<?php echo htmlspecialchars($table_name); ?>">
    <?php foreach ($questions as $index => $question): ?>
        <p><?php echo ($index + 1) . ". " . $question['question']; ?></p>
        <label><input type="radio" name="q<?php echo $index; ?>" value="1"> <?php echo $question['option1']; ?></label>
        <label><input type="radio" name="q<?php echo $index; ?>" value="2"> <?php echo $question['option2']; ?></label>
        <label><input type="radio" name="q<?php echo $index; ?>" value="3"> <?php echo $question['option3']; ?></label>
        <label><input type="radio" name="q<?php echo $index; ?>" value="4"> <?php echo $question['option4']; ?></label><br>
    <?php endforeach; ?>
    <button type="submit">Submit</button>
</form>

    <?php endif; ?>
</body>
</html>
