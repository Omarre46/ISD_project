<?php
require '../includes/connection.php'; // Include database connection
session_start();

// Redirect if not logged in as an employee
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

$employee_id = intval($_SESSION['employee_id']); // Ensure employee ID is an integer

try {
    // Fetch pending service requests (where Employee_ID is NULL)
    $stmt = $pdo->prepare("
        SELECT 
            service.ID, 
            service.Name AS guest_name, 
            service.Type, 
            service.Guest_ID, 
            service.Employee_ID, 
            guest.Email 
        FROM service
        JOIN guest ON service.Guest_ID = guest.ID
        WHERE service.Employee_ID IS NULL
    ");
    $stmt->execute();
    $serviceRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching service requests: " . htmlspecialchars($e->getMessage()));
}

// Handle service request acceptance or rejection
if (isset($_GET['action'], $_GET['service_id'])) {
    $action = htmlspecialchars($_GET['action'], ENT_QUOTES, 'UTF-8');
    $service_id = intval($_GET['service_id']); // Ensure service ID is an integer

    try {
        if ($action === 'accept') {
            // Assign the service request to the current employee
            $stmt = $pdo->prepare("
                UPDATE service 
                SET Employee_ID = :employee_id, Status = 'Accepted' 
                WHERE ID = :service_id AND Employee_ID IS NULL
            ");
            $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
            $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
            $stmt->execute();

            $message = $stmt->rowCount() > 0 
                ? "Service request accepted." 
                : "Service request could not be updated. It may have been assigned already.";
        } else {
            $message = "Invalid action.";
        }
    } catch (PDOException $e) {
        $message = "Error processing request: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="./style/employee_page.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['employee_name'], ENT_QUOTES, 'UTF-8'); ?>!</h1>
            <a href="../users/logout.php">Logout</a>
        </header>

        <?php if (isset($message)): ?>
            <div class="message">
                <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        <?php endif; ?>

        <section class="service-requests">
            <h2>Pending Service Requests</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Guest Name</th>
                        <th>Service Type</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (!empty($serviceRequests)) {
                        foreach ($serviceRequests as $request): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($request['ID'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($request['guest_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($request['Type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($request['Email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <a href="?action=accept&service_id=<?php echo intval($request['ID']); ?>">Accept</a>
                                </td>
                            </tr>
                        <?php endforeach; 
                    } else { ?>
                        <tr>
                            <td colspan="5">No pending requests.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </div>
</body>


</html>
