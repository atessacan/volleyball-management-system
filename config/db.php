<?php

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "volleyball_management_system"
);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

?>