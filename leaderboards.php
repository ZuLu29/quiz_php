<?php
include = "connection.php";


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
</head>
<body>
<h1>Leaderboard</h1>
    
    <?php if ($leaderboard): ?>
        <table border="1">
            <thead>
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
    <?php else: ?>
        <p>No scores to display.</p>
    <?php endif; ?>

    <a href="index.php">Back to Quiz</a>
</body>
</html>