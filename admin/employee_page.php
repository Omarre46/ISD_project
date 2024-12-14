<?php
require '../includes/connection.php';
session_start();

// Redirect if not logged in as an employee
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];

// Fetch pending service requests (where Employee_ID is NULL)
$stmt = $conn->prepare("
    SELECT service.ID, service.Name AS guest_name, service.Type, service.Guest_ID, service.Employee_ID, guest.Email 
    FROM service
    JOIN guest ON service.Guest_ID = guest.ID
    WHERE service.Employee_ID IS NULL
");
$stmt->execute();
$result = $stmt->get_result();

// Handle service request acceptance or rejection
if (isset($_GET['action']) && isset($_GET['service_id'])) {
    $action = $_GET['action'];
    $service_id = $_GET['service_id'];

    if ($action === 'accept') {
        // Assign the service request to the current employee
        $stmt = $conn->prepare("UPDATE service SET Employee_ID = ? WHERE ID = ?");
        $stmt->bind_param("ii", $employee_id, $service_id);
        $stmt->execute();
        $message = "Service request accepted.";
    } elseif ($action === 'reject') {
        // Mark the service request as rejected (optional, could also delete or archive)
        $stmt = $conn->prepare("UPDATE service SET Employee_ID = -1 WHERE ID = ?");
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $message = "Service request rejected.";
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

        <?php if (isset($message)) { ?>
            <div class="message">
                <p><?php echo $message; ?></p>
            </div>
        <?php } ?>

        <section class="service-requests">
            <h2>Pending Service Requests</h2>
            <table>
                <thead>
                    <tr>
                        <th>Guest Name</th>
                        <th>Email</th>
                        <th>Service Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) { 
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['guest_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['Type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <a href="employee_page.php?action=accept&service_id=<?php echo $row['ID']; ?>">Accept</a>
                                    <a href="employee_page.php?action=reject&service_id=<?php echo $row['ID']; ?>">Reject</a>
                                </td>
                            </tr>
                    <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="4">No pending requests.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </div>
</body>

</html>
