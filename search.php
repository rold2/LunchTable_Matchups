<?php
require_once 'config.php';

header('Content-Type: application/json');

if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';
    $stmt = $pdo->prepare("SELECT id, full_name, is_active FROM players WHERE full_name LIKE ? ORDER BY full_name");
    $stmt->execute([$search]);
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($players);
}
?>