<?php
include_once('../config/db.php');

$email = htmlspecialchars($_GET['email']);

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM user WHERE email = :email");
$stmt->execute([':email' => $email]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo $result['total'];

?>