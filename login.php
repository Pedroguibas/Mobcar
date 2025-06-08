<?php
session_start();
$_SESSION['baseUrl'] =  'http://' . $_SERVER['SERVER_NAME'] . '/Mobcar/';
    $baseurl = $_SESSION['baseUrl'];

if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1)
    header('Location: ' . $baseurl . 'index.php');
?>