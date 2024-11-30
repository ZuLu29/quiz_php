<?php
include "connection.php";


$query = "SELECT username, score, date_taken FROM leaderboard order by score desc, date_taken asc limit 10";
$result = mysqli_query($conn, $query);

if (!$result){
    die("unable to connect to leaderboard: " . mysqli_error($conn));
}

$leaderboard = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEADERBOARD</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-4">Leaderboard</h1>

        <?php if ($leaderboard): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Rank</th>
                            <th>Username</th>
                            <th>Score</th>
                            <th>Date Taken</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rank = 1; // Track ranking
                        foreach ($leaderboard as $row): ?>
                            <tr>
                                <td><?php echo $rank++; ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo $row['score']; ?></td>
                                <td><?php echo $row['date_taken']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">No scores to display.</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="quiz.php" class="btn btn-primary">Back to Quiz</a>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript Bundle (optional, for advanced components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
