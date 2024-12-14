<?php
include '../includes/connection.php'; // Database connection file

// Initialize message variables
$message = '';
$messageClass = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $description = htmlspecialchars(trim($_POST['description']));
    $createdAt = date('Y-m-d H:i:s'); // Format timestamp as a string

    // Check if required fields are filled
    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($description)) {
        // Check if email is valid
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                // Prepare and execute the SQL statement
                $stmt = $conn->prepare("INSERT INTO feedback (first_name, last_name, email, phone, description, created_at) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('ssssss', $firstName, $lastName, $email, $phone, $description, $createdAt);

                if ($stmt->execute()) {
                    $message = 'Thank you for your feedback! We will get back to you soon.';
                    $messageClass = 'success'; // CSS class for success message
                } else {
                    $message = 'An error occurred while submitting your feedback. Please try again later.';
                    $messageClass = 'error'; // CSS class for error message
                }
            } catch (Exception $e) {
                $message = 'An error occurred: ' . $e->getMessage();
                $messageClass = 'error';
            }
        } else {
            $message = 'Please enter a valid email address.';
            $messageClass = 'error';
        }
    } else {
        $message = 'Please fill in all the required fields.';
        $messageClass = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style/contact.css">
    <link rel="stylesheet" href="../includes/style/navbar.css">
    <link rel="stylesheet" href="../includes/style/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Success message */
        .success {
            color: green;
            font-size: 16px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* Error message */
        .error {
            color: red;
            font-size: 16px;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <?php
        include('../includes/navbar.php');
        if (isset($_SESSION['loggedin'])) {

            $guest_id = $_SESSION['guest_id'];
            $hasReservation = false;

            $query = "SELECT COUNT(*) as reservation_count FROM reservation WHERE Guest_ID = ?";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("i", $guest_id); 
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $hasReservation = $row['reservation_count'] > 0;
                }
                $stmt->close();
            }

            if ($hasReservation)
                include('../includes/service.php');
        }
        ?>
    </div>

    <div class="contact">
        <div class="google-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13246.131959710738!2d35.4799490871582!3d33.90167949999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151f16dd38749253%3A0xc25f0ac5ac2581fc!2sFour%20Seasons%20Hotel%20Beirut!5e0!3m2!1sen!2slb!4v1733312203465!5m2!1sen!2slb" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="info">
            <div class="loc">
                <i class="fa-solid fa-location-dot"></i>
                <h4><i>Four Seasons Hotel, Beirut, Lebanon</i></h4>
            </div>

            <div class="phone">
                <i class="fa-solid fa-phone"></i>
                <h4><i>Phone: 961 (1) 761000</i></h4>
            </div>

            <div class="icons">
                <a href="https://x.com/FSBeirut"><i class="fa-brands fa-twitter"></i></a>
                <a href="https://www.facebook.com/FourSeasonsHotelBeirut" target="_blank"><i class="fa-brands fa-facebook" style="color: #055ffa;"></i></a>
                <a href="https://www.instagram.com/fsbeirut" target="_blank"><i class="fa-brands fa-square-instagram" style="color: #f70240;"></i></a>
                <h4><i>Visit us</i></h4>
            </div>
        </div>
    </div>

    <br>

    <div class="contact-form-container">
        <h2>Contact Us</h2>

        <!-- Display success or error message -->
        <?php if (!empty($message)) : ?>
            <p class="<?php echo $messageClass; ?>"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="contact.php" method="POST">
            <div class="form-group">
                <input type="text" name="first_name" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="last_name" placeholder="Last Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="tel" name="phone" placeholder="Phone Number">
            </div>
            <div class="form-group">
                <textarea name="description" placeholder="Write your message here..." required></textarea>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>

    <div class="footer">
        <?php include('../includes/footer.php'); ?>
    </div>
</body>

</html>