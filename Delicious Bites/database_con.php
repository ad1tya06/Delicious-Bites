<?php
$c = mysqli_connect("localhost", "root", "", "food_order");
if (!$c) {
    die("Connection failed: " . mysqli_connect_error());
}
?>