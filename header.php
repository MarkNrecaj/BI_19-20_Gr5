<?php
session_start();
include "session.php";
$obj =  new Session();

?>
<header>
    <!-- <div class="container"> -->
    <div class="icons">
        <a href="https://www.linkedin.com/" target="”_blank”" class="icon icon--linkedin"></a>
        <a href="https://www.twitter.com/" target="”_blank”" class="icon icon--twitter"></a>
        <a href="https://www.pinterest.com/" target="”_blank”" class="icon icon--pinterest"></a>
        <a href="mailto:drilonpa@gmail.com?subject = Feedback&body = Message" target="”_blank”" class="icon icon--google-plus"></a>
        <a href="https://rss.app/" target="”_blank”" class="icon icon--rss"></a>
    </div>
    <div class="title">
        <h1 class="title title--text">
            Booking
        </h1>

        <ul class="menuItem">
            <li class="menuItem menuItem--item">
                Book all kinds of tours
            </li>

            <li class="menuItem menuItem--item">
                <?php
                $login = '';
                if (!$obj->isLogin() || $obj->idExpire()) {
                    $login = '<a id="login" href="auth.php">Login</a>';
                } else {
                    $login = '<a id="login" href="logout.php">Logout</a>';
                }
                echo $login;
                ?>
            </li>
        </ul>
    </div>
    <!-- </div> -->
</header>

<nav class="MenuFrame">
    <div class="menu">
        <div class="container">
            <div class="row">
                <div class="col-2-of-3">
                    <div class="MainMenu">
                        <a href="main.php" class="MainMenu MainMenu--MenuItem">HomePage</a>
                        <a href="tours.php" class="MainMenu MainMenu--MenuItem">Tours</a>
                        <a href="booking.php" class="MainMenu MainMenu--MenuItem">Booking</a>
                        <?php
                        if (!$obj->isLogin() || $obj->idExpire()) {
                            $my_booking = '';
                        } else {
                            $my_booking = '<a href="mybooking.php" class="MainMenu MainMenu--MenuItem">My Bookings</a>';
                        }
                        echo $my_booking;
                        ?> <a href="gallery.php" class="MainMenu MainMenu--MenuItem">Stories</a>
                    </div>
                </div>
                <div class="col-1-of-3">
                    <form method="post" action="booking.php" class="b-search-form b-menu__search-form">
                        <input class="b-search-form__input" name="search_input" id="search_input" required type="text" placeholder="Search our website..." />
                        <input class="b-search-form__input b-search-form__input_button" type="submit" name="search" id="search" value="Search" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>