<?php
include = "connection.php";


$query = "SELECT username, score, date_taken FROM leaderboard order by score desc, date_taken asc limit 10";
$result = mysqli_query($conn, $query);

if (!$result){
    die("unable to connect to leaderboard: " . mysqli_error($conn));
}

$leaderboard = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>