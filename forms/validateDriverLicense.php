<?php
include_once('../config/db.php');

$cnh = htmlspecialchars($_POST['cnh']);

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM client WHERE cnh = :cnh");
$stmt->execute([':cnh' => $cnh]);
$cnh = $stmt->fetch(PDO::FETCH_ASSOC);

echo $cnh['total'];

?>