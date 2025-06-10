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

if (isset($userInfo)) {
    $_SESSION['logged'] = true;
    $_SESSION['userID'] = $userInfo['userID'];
    $_SESSION['userName'] = $userInfo['userName'];
    $_SESSION['userEmail'] = $userInfo['email'];
    $_SESSION['userAddress'] = array('cep' => $userInfo['cep'], 'state' => $userInfo['estado'], 'city' => $userInfo['cidade'], 'street' => $userInfo['rua'], 'houseNumber' => $userInfo['numero']);
} else {
    header('Location: ' . $_SESSION['baseUrl'] . 'login.php');
}

header('Location: ' . $_SESSION['baseUrl'] . 'index.php');
?>