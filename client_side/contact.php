<div class="navbar">
    <?php include('../includes/navbar.php'); ?>
</div>

<?php
// Include database connection
require '../includes/connection.php';

// Initialize messages
$error = "";
$successMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $description = trim($_POST['description']);

    // Validate inputs
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($description)) {
        $error = "All fields are required.";
    } else {
        // Format the current date as X/X/XXXX
        $createdAt = date("j/n/Y");  // Example: 12/12/2024

        // Prepare SQL query to insert feedback into the database
        $stmt = $conn->prepare("INSERT INTO feedback (first_name, last_name, email, phone, description, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $phone, $description, $createdAt);

        // Execute the query and check if successful
        if ($stmt->execute()) {
            $successMessage = "Your feedback has been submitted successfully!";
        } else {
            $error = "Error submitting feedback: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Submission</title>
    <link rel="stylesheet" href="../style/contact.css">
</head>
<body>

<!-- Display success or error message -->
<?php if (!empty($successMessage)): ?>
    <div class="success-message" style="color: green;">
        <?php echo htmlspecialchars($successMessage); ?>
    </div>
<?php elseif (!empty($error)): ?>
    <div class="error-message" style="color: red;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

</body>
</html>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/contact.css">
    <link rel="stylesheet" href="../includes/style/navbar.css">
    <link rel="stylesheet" href="../includes/style/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>

<body>
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
                    <input type="tel" name="phone" placeholder="Phone Number" required>
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