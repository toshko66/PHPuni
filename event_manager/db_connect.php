<?php
$mysqli = new mysqli("localhost", "root", "", "event_manegement");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
