<?php
session_start();
$_SESSION["session"]=false;
session_destroy();
header('location:inicio.php');
 ?>
