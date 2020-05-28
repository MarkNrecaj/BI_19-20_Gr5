function user_not_login() {
    location.href = "http://localhost/booking/auth.php";
}

function success_booking() {
    alert('Booking has been added');
}

function error_booking() {
    alert('You already have this booking');
}

function remove_success_booking() {

    alert('Booking has been removed');
    window.location = "http://localhost/booking/main.php";
}

function error_remove() {
    alert('Error');
}

function save_story() {
    alert('The story has been added');
    window.location = "http://localhost/booking/gallery.php";
}