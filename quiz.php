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
    $stmt = mysqli_prepare($conn, $query); 
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $username, $score);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_error($stmt)) {
            echo "Error saving score: " . mysqli_stmt_error($stmt);
        } else {
            echo "<h2>Your Score: $score/" . count($questions) . "</h2>";
            echo '<a href="quiz.php">Try Again</a> | <a href="leaderboards.php">View Leaderboard</a>';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">PHP QUIZ</h2>
        <form action="" method="post" class="p-4 bg-white rounded shadow">
            <div class="mb-3">
                <label for="uname" class="form-label">Username:</label>
                <input type="text" id="uname" name="uname" class="form-control" placeholder="Enter your username" required>
            </div>
            <?php foreach ($questions as $index => $question): ?>
                <fieldset class="mb-4">
                    <legend class="h5"><?php echo $question['question']; ?></legend>
                    <?php foreach ($question['options'] as $optionIndex => $option): ?>
                        <div class="form-check">
                            <input 
                                type="radio" 
                                name="question<?php echo $index; ?>" 
                                id="question<?php echo $index . '_' . $optionIndex; ?>" 
                                value="<?php echo $optionIndex; ?>" 
                                class="form-check-input">
                            <label 
                                for="question<?php echo $index . '_' . $optionIndex; ?>" 
                                class="form-check-label">
                                <?php echo $option; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</body>
</html>
