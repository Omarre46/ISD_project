<?php
include('../includes/connection.php');
//echo "Check in" . $_GET['check_in'];
//echo "Check out" . $_GET['check_out'];
 

$check_in_date = $_GET['check_in'] ?? null;
$check_out_date = $_GET['check_out'] ?? null;

if (!$check_in_date || !$check_out_date) {
    echo "Error: Missing check-in or check-out date.";
    exit;
}

echo "Check in" . htmlspecialchars($check_in_date);
echo "Check out" . htmlspecialchars($check_out_date);



$query = "SELECT r.ID, r.RoomName, r.RoomNumber, r.RoomCategory, r.Description, r.RoomPrice, r.RoomImage
                    FROM rooms r
                    LEFT JOIN reservation res
                    ON r.ID = res.Room_ID
                    AND NOT (
                        res.CheckOut <= '$check_in_date' OR  
                        res.CheckIn >= '$check_out_date'   
                    )
                    WHERE res.Room_ID IS NULL;";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="room">';
        echo '<img src="../admin/' . $row['RoomImage'] . '" alt="Room Image">';
        echo '<div class="room-info">';
        echo '<h3>Room Number: ' . htmlspecialchars($row['RoomNumber']) . '</h3>';
        echo '<h3>' . htmlspecialchars($row['RoomName']) . '</h3>';
        echo '<h3>' . htmlspecialchars($row['RoomCategory']) . ' Room</h3>';
        echo '<p>' . htmlspecialchars($row['Description']) . '</p>';
        echo '<div class="price">$' . htmlspecialchars($row['RoomPrice']) . ' Per Night</div>';
        echo '<form action="reservation.php" method="POST" onsubmit="return updateFormDates(this)">';
        echo '<input type="hidden" name="room_id" value="' . htmlspecialchars($row['ID']) . '">';
        echo '<input type="hidden" name="room_name" value="' . htmlspecialchars($row['RoomName']) . '">';
        echo '<input type="hidden" name="room_price" value="' . htmlspecialchars($row['RoomPrice']) . '">';
        echo '<input type="hidden" name="check_in" value="' . htmlspecialchars($check_in_date) . '">';
        echo '<input type="hidden" name="check_out" value="' . htmlspecialchars($check_out_date) . '">';
        echo '<button type="submit">Book Now</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div class="room">No Rooms Found</div>';
}
?>
 