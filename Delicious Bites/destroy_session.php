<?php
// Start the session
session_start();

// Destroy the session
session_destroy();
header("Location: timeout.html");
?>
