<!DOCTYPE html>
<html manifest="myWeb.appcache" lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="style/main.css" />
  <link rel="stylesheet" href="style/homepagecard.css" />
  <title>Concomitant</title>
  <script src="script/booking_item.js"></script>
</head>

<body>
  <?php
  include 'header.php';
  include 'booking_item.php';
  ?>
  <section id="slider">
    <div class="slideshow-container">
      <div class="mySlides fade">
        <img src="img/1.png" style="width: 800px; height: 360px;" />
      </div>
      <div class="mySlides fade">
        <img src="img/2.png" style="width: 800px; height: 360px;" />
      </div>
      <div class="mySlides fade">
        <img src="img/3.jpg" style="width: 800px; height: 360px;" />
      </div>

      <div class="mySlides fade">
        <img src="img/4.png" style="width: 800px; height: 360px;" />
      </div>

      <div class="mySlides fade">
        <img src="img/5.jpg" style="width: 800px; height: 360px;" />
      </div>
    </div>
    <br />

    <div style="text-align: center;">
      <span class="leftarrow" onclick="plusSlides(-1)">
        <img src="icon/left-arrow.png" alt="" /></span>

      <span class="dot" onclick="currentSlide(1)"></span>
      <span class="dot" onclick="currentSlide(2)"></span>
      <span class="dot" onclick="currentSlide(3)"></span>
      <span class="dot" onclick="currentSlide(4)"></span>
      <span class="dot" onclick="currentSlide(5)"></span>
      <span class="rightarrow" onclick="plusSlides(1)">
        <img src="icon/right-arrow.png" alt="" />
      </span>
    </div>
  </section>



  <section class="section-tours" id="section-tours">
    <div class="container">
      <div class="u-center-text u-margin-bottom-big">
        <h2 class="heading-secondary">
          Most popular tours
        </h2>
      </div>
      <?php
      $dbhost = 'localhost:3306';
      $dbuser = 'root';
      $dbpassword = '';
      $dbname = 'booking';

      $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

      $sql = "SELECT * FROM booking where previous_price is not null";

      $retval = mysqli_query($conn, $sql);
      $booking_arr = [];
      if (mysqli_num_rows($retval) > 0) {
        $booking_arr = [];
        while ($row = mysqli_fetch_assoc($retval)) {
          $booking_arr[] = $row;
        }
      }
      if (!$retval) {
        die("Nuk mund te mirren te dhenat " . mysqli_connect_error());
      }
      if (!$conn) {
        die("Nuk mund te lidhet me db " . mysqli_connect_error());
      } else {
        echo '<div class="row">';
        for ($i = 0; $i < count($booking_arr); $i++) {
          $test = "asdsadas";
          $style = 'style="background-image: linear-gradient(to right bottom, #ffb900, #ff7730),
          url(' . $booking_arr[$i]['img_url'] . ');"';
          $class_pic = 'card__picture--';
          $price_previous = ($booking_arr[$i]['previous_price']) ? ('<p class="card__price-value" style="text-decoration-line: line-through; font-size: 4rem;">$' . $booking_arr[$i]['previous_price'] . '</p>') : "";
          //DATE
          $db_date = $booking_arr[$i]['date'];
          $date_explode = explode("-", $db_date);
          $date = $date_explode[0] . ":" . $date_explode[1] . ":" . $date_explode[2];
          $convert_date = strtotime($db_date . ' + ' . $booking_arr[$i]['days'] . ' days');
          $new_format = date('d:m:Y', $convert_date);
          $today = date('d-m-Y') . '';
          $diff = date_diff(date_create($today), date_create($db_date));
          $day_number = (int) $diff->format("%R%a");
          $final_date = $day_number > 0 ? ($date . ' till ' . $new_format) : ('<span style="color:red;">expired</span>');
          $button_book = $day_number > 0 ? ('
          <form method="post" action="main.php">
          <input type="hidden" name="book_id" value="' . $booking_arr[$i]['id'] . '">
          <button name="book_now" id="book_now"class="btn btn--white">Book now!</button>
          </form>') : '';
          $description = strlen($booking_arr[$i]['description']) > 40 ? str_replace(substr($booking_arr[$i]['description'], 40, strlen($booking_arr[$i]['description'])), '...', $booking_arr[$i]['description']) : ($booking_arr[$i]['description']);




          printf('
          <div class="col-1-of-3">
            <div class="card">
              <div class="card__side card__side--front">
                <div class="card__picture ' . $class_pic . ($i % 3 + 1) . '" >
                  &nbsp;
                </div>
                <h4 class="card__heading">
                  <span class="card__heading-span--' . ($i % 3 + 1) . '">
                  ' . $booking_arr[$i]['title'] . '
                  </span>
                </h4>
                <div class="card__details">
                  <ul>
                  <li>' . $booking_arr[$i]['days'] . ' day tours</li>
                  <li>Up to ' . $booking_arr[$i]['capacity'] . ' people</li>
                  <li>2 tour guides</li>
                  <li>' . $description . '</li>
                  <li>Difficulty: ' . $booking_arr[$i]['difficult'] . '</li>
                  <li> ' . $final_date . ' </li>
                  </ul>
                </div>
              </div>
              <div class="card__side card__side--back card__side--back-1">
                <div class="card__cta">
                  <div class="card__price-box">
                  ' . $price_previous . '
                    <p class="card__price-value">$' . $booking_arr[$i]['price'] . '</p>
                  </div>
                  ' . $button_book . '
                </div>
              </div>
            </div>
          </div>
        ');
        }
        printf('</div>');
      }

      ?>
      <?php
      if (isset($_POST['book_now'])) {
        $id = $_POST['book_id'];
        if (!$obj->isLogin() || $obj->idExpire()) {
          echo  "<script> user_not_login();</script>";
        } else {
          $result = setBooking($id, $obj->getId());
          if ($result) {
            echo  "<script> success_booking();</script>";
          } else {
            echo  "<script> error_booking();</script>";
          }
        }
      }



      ?>
      <div class="u-center-text u-margin-top-huge">
        <a href="booking.php" class="btn btn--green">Discover all tours</a>
      </div>
    </div>
  </section>


  <?php include 'footer.php'; ?>
</body>
<script src="script/main.js"></script>
<script src="script/check.js"></script>

</html>