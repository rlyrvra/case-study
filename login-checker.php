<?php
if(!isset($_SESSION['id'])){
    header("Location: ". $SMARTWAGE_LOCATION ."/login.php?r=true");
    exit;
}

if(!isset($_SESSION['access_role'])){
    header("Location: ". $SMARTWAGE_LOCATION ."/login.php?r=true");
    exit;
}
?>