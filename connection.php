<?php 
    $host = 'localhost'; 
    $user = 'root'; 
    $pass = ''; 
    $dbname = 'conde_php_quiz';
    $port = '3307';
            
    $conn = mysqli_connect($host, $user, $pass, $dbname, $port);

    if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    echo "Connected succesfully!";
?>