<?php
include_once('../config/db.php');

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

$cep = $_POST['cep'];
$state = $_POST['state'];
$city = $_POST['city'];
$street = $_POST['street'];
$number = htmlspecialchars($_POST['houseNumber']);

$cnh = htmlspecialchars($_POST['cnh']);

$stmt = $conn->prepare("INSERT INTO user (userName, email, userPassword) VALUES (:userName, :email, MD5(:userPassword))");
$stmt->execute([':userName' => $name,
                ':email' => $email,
                ':userPassword' => $password]);

$stmt = $conn->prepare("SELECT userID FROM user WHERE email = :email AND userName = :userName");
$stmt->execute([':email' => $email,
                ':userName' => $name]);
$userID = $stmt->fetch(PDO::FETCH_ASSOC);
$userID = $userID['userID'];

$stmt = $conn->prepare("CALL insert_endereco(:cep, :estado, :cidade, :rua, :numero)");
$stmt->execute([':cep' => $cep,
                ':estado' => $state,
                ':cidade' => $city,
                ':rua' => $street,
                ':numero' => $number]);

$endID = $stmt->fetch(PDO::FETCH_ASSOC);
$endID = $endID['enderecoID'];

$stmt = $conn->prepare("INSERT INTO client (clientID, cnh, clientEnderecoID) VALUES (:id, :cnh, :endereco)");
$stmt->execute([':id' => $userID,
                ':cnh' => $cnh,
                ':endereco' => $endID]);
                


?>