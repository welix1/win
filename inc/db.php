<?php
$conn = mysqli_connect('localhost', 'root', '', 'win', 8889);

if (!$conn) {
    echo 'Error: ' . mysqli_connect_error();
}