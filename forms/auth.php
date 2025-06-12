<?php
session_start();
include_once('../config/db.php');
$baseurl = $_SESSION['baseUrl'];

$password = htmlspecialchars($_POST['password']);
$email = htmlspecialchars($_POST['email']);

$stmt = $conn->prepare("SELECT * FROM vw_client WHERE email = :email AND userPassword = MD5(:password)");
$stmt->execute([':password' => $password,
                ':email' => $email]);
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stmt->rowCount() > 0) {
    $_SESSION['logged'] = true;
    $_SESSION['userID'] = $userInfo['userID'];
    $_SESSION['userName'] = $userInfo['userName'];
    $_SESSION['userEmail'] = $userInfo['email'];
    $_SESSION['userAddress'] = array('cep' => $userInfo['cep'], 'state' => $userInfo['state'], 'city' => $userInfo['city'], 'street' => $userInfo['street'], 'houseNumber' => $userInfo['number']);
} else {
    header('Location: ' . $_SESSION['baseUrl'] . 'login.php');
}

header('Location: ' . $_SESSION['baseUrl'] . 'index.php');
?>