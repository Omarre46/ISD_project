<?php
include("admin_navbar.php");
require("../includes/connection.php");

// Fetch feedback from the database using PDO
try {
    $stmt = $pdo->prepare("SELECT * FROM feedback ORDER BY created_at DESC");
    $stmt->execute();
    $feedbackData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching feedback: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
?>
<link rel="stylesheet" href="./style/feedback.css">

<!-- Display Feedback List -->
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
                <td><?php echo htmlspecialchars($feedback['first_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($feedback['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($feedback['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($feedback['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($feedback['description'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($feedback['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <!-- Delete Button -->
                    <a href="delete_feedback.php?delete_id=<?php echo htmlspecialchars($feedback['id'], ENT_QUOTES, 'UTF-8'); ?>" 
                       onclick="return confirm('Are you sure you want to delete this feedback?');">
                        <button type="button" class="delete-btn">Delete</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
