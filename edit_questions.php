<?php
session_start();

// Handle remove question request
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['questions'][$index]);
    $_SESSION['questions'] = array_values($_SESSION['questions']); // Reindex array
}

// Handle edit request
if (isset($_POST['edit'])) {
    $index = $_POST['index'];
    $question = $_POST['question'];
    $options = [
        'A' => $_POST['optionA'],
        'B' => $_POST['optionB'],
        'C' => $_POST['optionC'],
        'D' => $_POST['optionD'],
    ];
    $_SESSION['questions'][$index] = ['question' => $question, 'options' => $options];
}

// Redirect to final display page
if (isset($_POST['finalize'])) {
    header("Location: final_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit MCQ Questions</title>
    <style>
        body {
            background-color: #D3D3D3;
            background-image: url(2.jpg);
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .question-box {
            background-color: white;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #000;
        }
        button {
            background-color: #00008B;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #1E90FF;
        }
    </style>
</head>
<body>

<h1>Edit MCQ Questions</h1>

<?php
if (!empty($_SESSION['questions'])) {
    foreach ($_SESSION['questions'] as $index => $q) {
        echo '<div class="question-box">';
        echo '<form method="POST">';
        echo '<label><strong>Question ' . ($index + 1) . ':</strong></label><br>';  // Add serial number here
        echo '<input type="text" name="question" value="' . htmlspecialchars($q['question']) . '" required><br>';
        echo '<label>Option A:</label><br>';
        echo '<input type="text" name="optionA" value="' . htmlspecialchars($q['options']['A']) . '" required><br>';
        echo '<label>Option B:</label><br>';
        echo '<input type="text" name="optionB" value="' . htmlspecialchars($q['options']['B']) . '" required><br>';
        echo '<label>Option C:</label><br>';
        echo '<input type="text" name="optionC" value="' . htmlspecialchars($q['options']['C']) . '" required><br>';
        echo '<label>Option D:</label><br>';
        echo '<input type="text" name="optionD" value="' . htmlspecialchars($q['options']['D']) . '" required><br>';
        echo '<input type="hidden" name="index" value="' . $index . '">';
        echo '<button type="submit" name="edit">Edit Question</button>';
        echo '</form>';
        echo '<br><a href="edit_questions.php?remove=' . $index . '">Remove Question</a>';
        echo '</div>';
    }
}
?>

<form method="POST">
    <button type="submit" name="finalize">Submit and Finalize</button>
</form>

</body>
</html>
