<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="ie=edge" http-equiv="X-UA-Compatible" />
  <link href="style/gallery.css" rel="stylesheet" />
  <title>Gallery</title>
</head>

<body>
  <?php include 'header.php'; ?>

  <section class="section-stories">
    
    <div class="bg-video">
      <video class="bg-video__content" autoplay muted loop>
        <source src="img/video.mp4" type="video/mp4" />
        <source src="img/video.webm" type="video/webm" />
        Your broswer is not supported!
      </video>
    </div>

    <div class="u-center-text u-margin-bottom-big">
      <h2 class="heading-secondary">
        We make people genuinely happly
      </h2>
    </div>
    <?php

    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpassword = '';
    $dbname = 'booking';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    $user_id = $obj->getId();
    $sql = "SELECT u.fullname,s.* FROM stories s join users u on u.id= s.user_id order by s.id desc";

    $retval = mysqli_query($conn, $sql);
    if (!$retval) {
      die("Nuk mund te mirren te dhenat " . mysqli_connect_error());
    }
    $story = [];
    if (mysqli_num_rows($retval) > 0) {
      while ($row = mysqli_fetch_assoc($retval)) {
        $story[] = $row;
      }
    }
    for ($i = 0; $i < count($story); $i++) {
      $img = $story[$i]['image_url'];
      echo ('    <div class="row">
          <div class="story">
         <figure class="story__shape">
           <img src="' . $img . '" alt="Person on a tour" class="story__img" />
           <figcaption class="story__caption">
             ' . $story[$i]['fullname'] . '
           </figcaption>
         </figure>
         <div class="story__text">
           <h3 class="heading-tertiary u-margin-bottom-small">
           ' . $story[$i]['title'] . '
           </h3>
           <p>
           ' . $story[$i]['description'] . '
           </p>
         </div>
       </div>
      </div>');
    }



    ?>
  </section>

  <?php include 'footer.php'; ?>
  <script src="script/check.js"></script>
</body>

</html>