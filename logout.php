<?php
    setcookie('id', null, time() - 3600 * 24 * 30 * 12);
    header("Location: index.php"); 
    exit;
?>