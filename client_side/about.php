<div class="navbar">
  <?php
  include('../includes/connection.php');
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link rel="stylesheet" href="style/about.css">
  <link rel="stylesheet" href="../includes/style/navbar.css">
  <link rel="stylesheet" href="../includes/style/footer.css">
</head>

<body>
  <div class="about-us">
    <section class="story">
      <h1>Our Story</h1>
      <p>At Four Seasons, we believe in creating unforgettable experiences by combining exceptional hospitality, warm smiles, and a passion for excellence. Our journey is rooted in the love for serving our guests and making every stay a cherished memory.</p>
    </section>
    <div class="content">
      <!-- First container -->
      <div class="image-container design-one">
        <div class="caption">Experience ultimate comfort in our elegant rooms, thoughtfully designed for a restful stay with luxurious amenities and cozy ambiance.</div>
        <div class="image"></div>
      </div>

      <!-- Second container (image + description beside it) -->
      <div class="image-container design-two">
        <div class="image"></div>
        <div class="description">
          <h2>Step into a welcoming atmosphere in our lobby, where modern design meets warm hospitality for an unforgettable first impression.</h2>
        </div>
      </div>

      <!-- Third container -->
      <div class="image-container design-three">
        <div class="caption">Indulge in exquisite culinary experiences at our restaurant, featuring breathtaking city views and a meticulously crafted menu.</div>
        <div class="image"></div>
      </div>
    </div>
  </div>
</body>

</html>

<div class="footer">
  <?php include('../includes/footer.php'); ?>
</div>