<?php
/**
 * This PHP page will respond to DELETE form request from a user.
 */
require_once 'config.php';

if(isset($_SESSION['user_email'])){
    
    $sql = "SELECT * FROM `forms` WHERE `id` = {$_GET['id']} AND `users_email` = '{$_SESSION['user_email']}'";
    $result = $connection->query($sql);
    
    if($result->num_rows > 0){
       $sql = "DELETE FROM `forms_fields` WHERE `forms_id` = {$_GET['id']}";
       $connection->query($sql); 
    }
    
    $sql = "DELETE FROM `forms` WHERE `id` = {$_GET['id']} AND `users_email` = '{$_SESSION['user_email']}'";
    $result = $connection->query($sql); 
}

header('Location: index.php');;
