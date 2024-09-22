<?php
session_start();

// Initialize session array to store questions
if (!isset($_SESSION['questions'])) {
    $_SESSION['questions'] = [];
}

// Handle form submission for adding questions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        // Add a new question and options to the session array
        $question = $_POST['question'];
        $options = [
            'A' => $_POST['optionA'],
            'B' => $_POST['optionB'],
            'C' => $_POST['optionC'],
            'D' => $_POST['optionD'],
        ];
        $_SESSION['questions'][] = ['question' => $question, 'options' => $options];
    } elseif (isset($_POST['finalize'])) {
        // Redirect to the display and edit page
        header("Location: edit_questions.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: Add MCQ Questions</title>
    <style>
        body {
            background-color: #D3D3D3;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        button {
            margin-right: 10px;
            padding: 10px;
            background-color: #00008B;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #1E90FF;
        }
    </style>
</head>
<body>

<h1>Admin: Input MCQ Questions</h1>
<form method="POST">
    <div class="form-group">
        <label>Question:</label>
        <input type="text" name="question" required>
    </div>
    <div class="form-group">
        <label>Option A:</label>
        <input type="text" name="optionA" required>
    </div>
    <div class="form-group">
        <label>Option B:</label>
        <input type="text" name="optionB" required>
    </div>
    <div class="form-group">
        <label>Option C:</label>
        <input type="text" name="optionC" required>
    </div>
    <div class="form-group">
        <label>Option D:</label>
        <input type="text" name="optionD" required>
    </div>
    
    <!-- Two buttons: Add More Questions and Finalize -->
    <button type="submit" name="add">Add More Questions</button>
    <button type="submit" name="finalize">Finalize</button>
</form>

<?php
// If there are existing questions, show them in a preview list
if (!empty($_SESSION['questions'])) {
    echo '<h3>Current Questions:</h3>';
    echo '<ul>';
    foreach ($_SESSION['questions'] as $index => $q) {
        echo '<li>' . ($index + 1) . '. ' . htmlspecialchars($q['question']) . '</li>';
    }
    echo '</ul>';
}
?>

</body>
</html>
