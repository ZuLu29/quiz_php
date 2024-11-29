<?php 
include "connection.php";
$questions = [
    [
        "question" => "What does PHP stand for?",
        "options" => ["Personal Home Page", "Private Home Page", "PHP: Hypertext Preprocessor", "Public Hypertext Preprocessor"],
        "answer" => 2
    ],
    [
        "question" => "Which symbol is used to access a property of an object in PHP?",
        "options" => [".", "->", "::", "#"],
        "answer" => 1
    ],
    [
        "question" => "Which function is used to include a file in PHP?",
        "options" => ["include()", "require()", "import()", "load()"],
        "answer" => 0
    ]
];

$score = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach($questions as $index => $question) {
        if (isset($_POST["question$index"]) && $_POST["question$index"] == $question['answer']) {
            $score++;
        }
    }
    $username = htmlspecialchars($_POST['uname']);
    $query = "insert into leaderboard (username, score) values(?, ?)";
    $stmt = mysqli_prepare($sonn, $query); 
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $username, $score);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_error($stmt)) {
            echo "Error saving score: " . mysqli_stmt_error($stmt);
        } else {
            echo "<h2>Your Score: $score/" . count($questions) . "</h2>";
            echo '<a href="index.php">Try Again</a> | <a href="leaderboard.php">View Leaderboard</a>';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($conn);
    }

    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP QUIZ</title>
</head>
<body>
    <h2>PHP QUIZ</h2>
    <form action="" method="post">
        <label for="uname">Username:</label>
        <input type="text" id="uname" name="uname" placeholder="username" required>
        <br>
        <?php foreach($questions as $index => $question): ?>
            <fieldset>
                <legend><?php echo $question['question']; ?></legend>
                <?php foreach ($question['options'] as $optionIndex => $option):?>
                    <label>
                        <input type="radio" name="question<?php echo $index; ?>" value="<?php echo $optionIndex; ?>">
                        <?php echo $option; ?>
                    </label><br>
                <?php endforeach; ?>
            </fieldset>
        <?php endforeach; ?>
        <button type="submit">Submit</button>
    </form>
</body>
</html>