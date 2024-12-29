<div class="navbar">
  <?php
  include('../includes/connection.php');
  include('../includes/navbar.php');
  ?>
</div>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../includes/style/navbar.css">
  <link rel="stylesheet" href="../includes/style/footer.css">
  <link rel="stylesheet" href="../client_side/style/about.css">
  <title>About Four Seasons</title>

</head>

<body>
  <section class="hero">
    <div class="hero-content">
      <h1>Our Story</h1>
      <p>Since our founding, Four Seasons has been dedicated to perfecting the travel experience through continual innovation and the highest standards of hospitality. From elegant surroundings of the finest quality, to caring, highly personalized 24-hour service, Four Seasons embodies a true home away from home for those who know and appreciate the best.</p>
    </div>
  </section>

  <section class="features">
    <div class="feature-grid">
      <div class="feature-card">
        <div class="feature-image" style="background-image: url('./imgs/hotel_laundryjpg.jpg')"></div>
        <div class="feature-content">
          <h2 class="feature-title">Luxurious Accommodations</h2>
          <p class="feature-text">Experience ultimate comfort in our elegant rooms, thoughtfully designed for a restful stay with luxurious amenities and cozy ambiance.</p>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-image" style="background-image: url('./imgs/hotel_lobby.jpg')"></div>
        <div class="feature-content">
          <h2 class="feature-title">Grand Welcome</h2>
          <p class="feature-text">Step into a welcoming atmosphere in our lobby, where modern design meets warm hospitality for an unforgettable first impression.</p>
        </div>
      </div>

      <div class="feature-card">
        <div class="feature-image" style="background-image: url('./imgs/hotel_bar.jpg')"></div>
        <div class="feature-content">
          <h2 class="feature-title">Fine Dining</h2>
          <p class="feature-text">Indulge in exquisite culinary experiences at our restaurant, featuring breathtaking city views and a meticulously crafted menu.</p>
        </div>
      </div>
    </div>
  </section>

  <div class="footer">
    <?php include('../includes/footer.php'); ?>
  </div>
</body>

</html>