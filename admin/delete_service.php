<?php
require '../includes/connection.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['service_id'])) {
    $serviceId = htmlspecialchars($_GET['service_id'], ENT_QUOTES, 'UTF-8');

    if (!is_numeric($serviceId)) {
        echo "Invalid service ID.";
        exit();
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM service WHERE ID = :id");
        $stmt->bindParam(':id', $serviceId, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: client_requests.php");
        exit();
    } catch (PDOException $e) {
        die("Error deleting service: " . htmlspecialchars($e->getMessage()));
    }
} else {
    header("Location: client_requests.php");
    exit();
}
?>
