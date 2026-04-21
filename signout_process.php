<?php
session_start();  // resume the existing session
session_destroy(); // wipe all session variables
header("Location: index.php");
exit;

