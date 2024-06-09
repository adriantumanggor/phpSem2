<?php
// Konfigurasi database
$servername = "localhost"; // Ganti dengan nama server MySQL Anda jika berbeda
$username = "root"; // Ganti dengan username MySQL Anda
$password = "root"; // Ganti dengan password MySQL Anda
$database = "elearning"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

?>
