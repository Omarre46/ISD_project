<?php
include("admin_navbar.php");
require("../includes/connection.php");

// Fetch feedback from the database
$feedbackData = [];
$stmt =  $conn->prepare("SELECT * FROM feedback ORDER BY created_at DESC"); 
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $feedbackData[] = $row;
}
$stmt->close();
?>
<link rel="stylesheet" href="./style/feedback.css">

<table border="1">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            <th>Submitted On</th>
            <th>Action</th> <!-- Column for delete button -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($feedbackData as $feedback): ?>
            <tr>
                <td><?php echo htmlspecialchars($feedback['first_name']); ?></td>
                <td><?php echo htmlspecialchars($feedback['last_name']); ?></td>
                <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                <td><?php echo htmlspecialchars($feedback['phone']); ?></td>
                <td><?php echo htmlspecialchars($feedback['description']); ?></td>
                <td><?php echo htmlspecialchars($feedback['created_at']); ?></td>
                <td>
                    <!-- Delete Button -->
                    <a href="delete_feedback.php?delete_id=<?php echo $feedback['id']; ?>" onclick="return confirm('Are you sure you want to delete this feedback?');">
                        <button type="button" class="delete-btn">Delete</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
