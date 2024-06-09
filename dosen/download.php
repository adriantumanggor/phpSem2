<?php

session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

// Include file konfigurasi dan fungsi
include('../function/config.php');
include('../function/functions.php');

// Pengecekan role pengguna
if ($_SESSION['role'] !== 'dosen') {
    header("Location: ../error_page.php");
    exit;
}

if (isset($_GET['file_url']) && isset($_GET['file_name'])) {
    $fileUrl = $_GET['file_url'];
    $fileName = $_GET['file_name'];
    downloadFile($fileUrl, $fileName);
} else {
    header("Location: ../error_page.php");
    exit;
}