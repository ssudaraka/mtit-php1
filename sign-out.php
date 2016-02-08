<?php
/**
 * Basic page to handle user's sign out request.
 */
session_start();
session_unset();
header('Location: index.php');

?>