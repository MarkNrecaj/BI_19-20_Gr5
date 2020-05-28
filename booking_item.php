<?php
function setBooking($id, $user_id)
{
    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpassword = '';
    $dbname = 'booking';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

    if (!$conn) {
        die("Nuk mund te lidhet me db " . mysqli_connect_error());
    }

    $sql_chechk = "SELECT * FROM user_booking where booking_id = $id and user_id = $user_id";
    $retval_check = mysqli_query($conn, $sql_chechk);
    if (!$retval_check) {
        die("Gabim " . mysqli_connect_error());
    }
    if (mysqli_num_rows($retval_check) > 0) {
        return false;
    }

    $sql = "INSERT INTO user_booking(booking_id,user_id)
    VALUES ($id,$user_id);";

    $retval = mysqli_query($conn, $sql);
    if (!$retval) {
        die("Nuk mund te shtohen te dhenat " . mysqli_connect_error());
    }

    mysqli_close($conn);

    return true;
}

function removeBooking($id)
{
    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpassword = '';
    $dbname = 'booking';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

    if (!$conn) {
        die("Nuk mund te lidhet me db " . mysqli_connect_error());
    }
    $sql = "DELETE FROM user_booking where id=$id";

    $retval = mysqli_query($conn, $sql);
    if (!$retval) {
        die("Nuk mund te shtohen te dhenat " . mysqli_connect_error());
    }

    mysqli_close($conn);

    return true;
}

function saveStorie($path, $description, $title, $user_id)
{
    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpassword = '';
    $dbname = 'booking';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

    if (!$conn) {
        die("Nuk mund te lidhet me db " . mysqli_connect_error());
    }

    $sql = "INSERT INTO stories(user_id,description,title,image_url)
    VALUES ($user_id,'$description','$title','$path');";
    var_dump($sql);
    $retval = mysqli_query($conn, $sql);
    if (!$retval) {
        die("Nuk mund te shtohen te dhenat " . mysqli_connect_error());
    }

    mysqli_close($conn);

    return true;
}
