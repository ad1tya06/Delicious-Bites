<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Establish connection
    include "database_con.php";
    // Sanitize inputs
    $name = mysqli_real_escape_string($c, $_POST['name']);
    $mail = mysqli_real_escape_string($c, $_POST['email']);
    $subject = mysqli_real_escape_string($c, $_POST['subject']);
    $message = mysqli_real_escape_string($c, $_POST['message']);

    // Insert data into database using prepared statement
    $q = "INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($c, $q);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $mail, $subject, $message);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: message.html");
        exit();
    } else {
        echo "Error: " . mysqli_error($c);
    }

    // Close connection
    mysqli_stmt_close($stmt);
    mysqli_close($c);
}
?>