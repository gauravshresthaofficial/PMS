<?php
// logout.php

// Start the session
session_start();

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

// Return a response indicating success
header("location: index.php?");
// echo 1;
?>
