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

// If form is submitted, process the array of questions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_questions'])) {
    $questions = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $correct = $_POST['correct'];

    // Create a table name based on the current date and time
    $table_name = "questions_" . date("Ymd_His");
    $create_table_sql = "CREATE TABLE $table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        question TEXT NOT NULL,
        option1 VARCHAR(255) NOT NULL,
        option2 VARCHAR(255) NOT NULL,
        option3 VARCHAR(255) NOT NULL,
        option4 VARCHAR(255) NOT NULL,
        correct_option INT(1) NOT NULL
    )";

    if ($conn->query($create_table_sql) === TRUE) {
        // Loop through all the submitted questions
        for ($i = 0; $i < count($questions); $i++) {
            $q = mysqli_real_escape_string($conn, $questions[$i]);
            $opt1 = mysqli_real_escape_string($conn, $option1[$i]);
            $opt2 = mysqli_real_escape_string($conn, $option2[$i]);
            $opt3 = mysqli_real_escape_string($conn, $option3[$i]);
            $opt4 = mysqli_real_escape_string($conn, $option4[$i]);
            $corr = (int)$correct[$i];

            // Insert each question into the newly created table
            $sql = "INSERT INTO $table_name (question, option1, option2, option3, option4, correct_option) 
                    VALUES ('$q', '$opt1', '$opt2', '$opt3', '$opt4', $corr)";
            
            if ($conn->query($sql) === TRUE) {
                echo "Question added successfully!<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

// Handle delete request
if (isset($_POST['delete_question'])) {
    $table_name = $_POST['table_name'];
    $question_id = $_POST['question_id'];
    $delete_sql = "DELETE FROM $table_name WHERE id = $question_id";
    
    if ($conn->query($delete_sql) === TRUE) {
        echo "Question deleted successfully!";
    } else {
        echo "Error deleting question: " . $conn->error;
    }
}

// Function to fetch previous questions
function fetchPreviousQuestions($conn) {
    $tables_result = $conn->query("SHOW TABLES LIKE 'questions_%'");
    while ($table_row = $tables_result->fetch_array()) {
        $table_name = $table_row[0];
        echo "<h3>Questions from $table_name</h3>";
        $questions_result = $conn->query("SELECT * FROM $table_name");

        if ($questions_result->num_rows > 0) {
            while ($question_row = $questions_result->fetch_assoc()) {
                echo "<div class='question-set'>";
                echo "<p><strong>Question:</strong> " . htmlspecialchars($question_row['question']) . "</p>";
                echo "<p><strong>Option 1:</strong> " . htmlspecialchars($question_row['option1']) . "</p>";
                echo "<p><strong>Option 2:</strong> " . htmlspecialchars($question_row['option2']) . "</p>";
                echo "<p><strong>Option 3:</strong> " . htmlspecialchars($question_row['option3']) . "</p>";
                echo "<p><strong>Option 4:</strong> " . htmlspecialchars($question_row['option4']) . "</p>";
                echo "<p><strong>Correct Option:</strong> " . htmlspecialchars($question_row['correct_option']) . "</p>";
                echo "<form action='admin.php' method='POST'>
                        <input type='hidden' name='table_name' value='$table_name'>
                        <input type='hidden' name='question_id' value='" . $question_row['id'] . "'>
                        <button type='submit' name='delete_question'>Delete</button>
                      </form>";
                echo "</div>";
            }
        } else {
            echo "<p>No questions found in this set.</p>";
        }
    }
}

// Check if the "view previous" button was pressed
$view_previous = isset($_POST['view_previous']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: Add MCQ Questions</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let questionCount = 1;

        // Function to add new question set dynamically
        function addQuestionSet() {
            const container = document.getElementById('question-container');
            const questionHTML = `
            <div class="question-set">
                <h3>Question ${questionCount + 1}</h3>
                <label for="question">Question:</label><br>
                <textarea name="question[]" rows="4" cols="50" required></textarea><br><br>

                <label for="option1">Option 1:</label><br>
                <input type="text" name="option1[]" required><br><br>

                <label for="option2">Option 2:</label><br>
                <input type="text" name="option2[]" required><br><br>

                <label for="option3">Option 3:</label><br>
                <input type="text" name="option3[]" required><br><br>

                <label for="option4">Option 4:</label><br>
                <input type="text" name="option4[]" required><br><br>

                <label for="correct">Correct Option (1-4):</label><br>
                <input type="number" name="correct[]" min="1" max="4" required><br><br>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', questionHTML);
            questionCount++;
        }
    </script>
</head>
<body>
    <h2>Add Multiple MCQ Questions</h2>

    <form action="admin.php" method="POST">
        <div id="question-container">
            <div class="question-set">
                <h3>Question 1</h3>
                <label for="question">Question:</label><br>
                <textarea name="question[]" rows="2" cols="50" placeholder="Add your question here..." required></textarea><br><br>

                <label for="option1">Option 1:</label><br>
                <input type="text" name="option1[]" placeholder="Insert option 1" required><br><br>

                <label for="option2">Option 2:</label><br>
                <input type="text" name="option2[]" placeholder="Insert option 2" required><br><br>

                <label for="option3">Option 3:</label><br>
                <input type="text" name="option3[]" placeholder="Insert option 3" required><br><br>

                <label for="option4">Option 4:</label><br>
                <input type="text" name="option4[]" placeholder="Insert option 4" required><br><br>

                <label for="correct">Correct Option (1-4):</label><br>
                <input type="number" name="correct[]" min="1" max="4" placeholder="Select correct option (1-4)" required><br><br>
            </div>
        </div>
        <div>
            <button type="button" onclick="addQuestionSet()">Add More Questions</button>&nbsp;&nbsp;&nbsp;
            <button type="submit" name="submit_questions">Submit Questions to Database</button>
        </div>
    </form>

    <div>
        <form action="admin.php" method="POST">
        &nbsp;
            <button type="submit" name="view_previous">View Previous Questions</button>
        </form>
    </div>

    <!-- Display previous questions if requested -->
    <div id="previous-questions">
        <?php if ($view_previous) fetchPreviousQuestions($conn); ?>
    </div>
</body>
</html>
