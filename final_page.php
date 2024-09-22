<?php
session_start();

// Redirect to admin page if no questions are available
if (!isset($_SESSION['questions']) || empty($_SESSION['questions'])) {
    header("Location: admin_page.php");
    exit();
}

// Function to display the questions with watermark
function displayQuestions($questions) {
    echo '<div style="position: relative; padding: 20px; border-radius: 5px;">';
    echo '<div style="position: absolute; opacity: 0.2; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(45deg); font-size: 100px; color: #00008b; font-family: \'Courier New\', Courier, monospace; font-weight: bold; text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.4);">MAPS WITH NAVEEN</div>';

    $counter = 1;
    foreach ($questions as $q) {
        echo '<div style="border: 0px solid #000; padding: 10px; margin-bottom: 10px; background-color: white;">';
        echo '<div style="color: #00008B; font-size: 20px; font-weight: bold;">' . $counter . '. ' . htmlspecialchars($q['question']) . '</div>';
        foreach ($q['options'] as $key => $option) {
            echo '<div style="color: #ADD8E6; font-size: 16px;">' . $key . ') ' . htmlspecialchars($option) . '</div>';
        }
        echo '</div>';
        $counter++;
    }
    echo '</div>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final MCQ Questions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
    </style>
</head>
<body>

<h1>MCQ QUESTION</h1>

<?php
// Display the questions with a watermark
displayQuestions($_SESSION['questions']);
?>

</body>
</html>
