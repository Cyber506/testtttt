<?php
$host = 'mzag-server.mysql.database.azure.com';
$dbname = 'jj';
$username = 'apvaxcickj';
$password = 'Coco@1234';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ddفشل الاتصال بقاعدة البياkkkkنات.");
}

$ip = $_SERVER['REMOTE_ADDR'];

// تحقق هل هذا الـ IP زار اليوم بالفعل
$stmt = $pdo->prepare("SELECT COUNT(*) FROM visits WHERE ip_address = ? AND DATE(visit_time) = CURDATE()");
$stmt->execute([$ip]);
$already_visited = $stmt->fetchColumn();

if ($already_visited == 0) {
    // لم يُسجّل اليوم، نسجله الآن
    $stmt = $pdo->prepare("INSERT INTO visits (ip_address) VALUES (?)");
    $stmt->execute([$ip]);
}
?>
