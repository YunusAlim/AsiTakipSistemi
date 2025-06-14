<?php
require 'auth.php';
require 'db.php';

$id = $_GET['id'];

// Admin kontrolü
if ($_SESSION['user_role'] === 'admin') {
    // Admin yetki
    $stmt = $pdo->prepare("DELETE FROM vaccinations WHERE id = ?");
    $stmt->execute([$id]);
} else {
    //  kendi aşılarını sil
    $stmt = $pdo->prepare("DELETE FROM vaccinations WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
}

if (isset($_GET['from_admin']) && $_GET['from_admin'] === 'true') {
    header("Location: admin.php");
} else {
    header("Location: dashboard.php");
}
exit;
?>
