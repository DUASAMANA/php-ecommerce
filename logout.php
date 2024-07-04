<?php
session_start();
session_destroy();
header("Location: project.html"); // Redirect to the home page after logout
?>
