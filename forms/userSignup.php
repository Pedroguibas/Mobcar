<?php
include_once('../config/db.php');
session_start();

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

$cep = $_POST['cep'];
$state = $_POST['state'];
$city = $_POST['city'];
$street = $_POST['street'];
$number = htmlspecialchars($_POST['houseNumber']);

$cnh = htmlspecialchars($_POST['cnh']);


$stmt = $conn->prepare("CALL insert_client(:email, :name, :password, :cnh, :cep, :state, :city, :street, :number)");
$stmt->execute([':email' => $email,
                ':name' => $name,
                ':password' => $password,
                ':cnh' => $cnh,
                ':cep' => $cep,
                ':state' => $state,
                ':city' => $city,
                ':street' => $street,
                ':number' => $number]);

$_SESSION['logged'] = true;
$_SESSION['userID'] = $userID;
$_SESSION['userName'] = $name;
$_SESSION['userEmail'] = $email;
$_SESSION['userAddress'] = array('cep' => $cep, 'state' => $state, 'city' => $city, 'street' => $street, 'houseNumber' => $number);

header('Location: ' . $_SESSION['baseUrl'] . 'index.php');
?>