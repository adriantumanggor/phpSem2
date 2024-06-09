<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] !== 'dosen') {
    header("Location: ../error_page.php");
    exit;
}

include('../function/config.php');
include('../function/functions.php');

if (isset($_POST['submission_id']) && isset($_POST['grade'])) {
    $submission_id = $_POST['submission_id'];
    $grade = $_POST['grade'];

    // Validate the grade input
    if (!is_numeric($grade) || $grade < 0 || $grade > 100) {
        header("Location: ../error_page.php");
        exit;
    }

    // Update the submission grade
    $query = "UPDATE submissions SET grade = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $grade, $submission_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: daftar_pengumpulan.php");
        exit;
    } else {
        header("Location: ../error_page.php");
        exit;
    }
} else {
    header("Location: ../error_page.php");
    exit;
}