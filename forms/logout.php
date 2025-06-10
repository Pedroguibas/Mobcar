<?php
session_start();
$baseurl = $_SESSION['baseUrl'];
$_SESSION = array();
header('Location: ' . $baseurl . 'login.php');
?>