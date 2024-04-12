<?php
$c = mysqli_connect("sql104.hstn.me", "mseet_36047537", "Activa125", "mseet_36047537_food_order");
if (!$c) {
    die("Connection failed: " . mysqli_connect_error());
}
?>


<!-- localhost dtabase connection -->
<?php
$c = mysqli_connect("localhost", "root", "", "food_order");
if (!$c) {
    die("Connection failed: " . mysqli_connect_error());
}
?>