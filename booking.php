<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Establish connection
    include "database_con.php";
    $q="select count from avail;";
    $result=mysqli_query($c,$q);
    $num=mysqli_fetch_array($result);
    if($num["count"]==6){
        header("Location: sorry.html");
        exit();
    }
    else{
       $inc= $num["count"];
       $q="UPDATE avail set count=$inc+1 where count=$inc;";
    $result=mysqli_query($c,$q);
    }
    // Sanitize inputs
    $name = mysqli_real_escape_string($c, $_POST['name']);
    $mail = mysqli_real_escape_string($c, $_POST['email']);
    $date = mysqli_real_escape_string($c, $_POST['date']);
    $time = mysqli_real_escape_string($c, $_POST['time']);
    $people = mysqli_real_escape_string($c, $_POST['people']);
    $request = isset($_POST['request']) ? mysqli_real_escape_string($c, $_POST['request']) : 'No special Request';

    // Insert data into database using prepared statement
    $q = "INSERT INTO reservation (name, email, date, time, people, request) VALUES (?,?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($c, $q);
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $mail, $date, $time, $people, $request);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: table_confirm.html");
        exit();
    } else {
        echo "Error: " . mysqli_error($c);
    }

    // Close connection
    mysqli_stmt_close($stmt);
    mysqli_close($c);
}
?>