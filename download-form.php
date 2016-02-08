<?php

/**
 * This page will generate the form in HTML and form download the HTML page to
 * user's desktop
 */

session_start();

header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=myform.html");
header("Content-Type: application/octet-stream; "); 
header("Content-Transfer-Encoding: binary");

echo "<html>";
echo "<head><title>{$_SESSION['form_title']}</title></head>";
echo "<body>";
echo $_SESSION['form_string'];
echo "</body>";
echo "</html>";
