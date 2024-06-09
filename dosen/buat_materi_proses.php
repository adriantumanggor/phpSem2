<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location:../login.php");
    exit;
}

if ($_SESSION['role'] !== 'dosen') {
    header("Location:../error_page.php");
    exit;
}

include('../function/config.php');
include('../function/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['material_title'];
    $description = $_POST['material_description'];
    $uploaded_by = $_SESSION['id'];
    $file_url = NULL;

    // Check if a file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $target_dir = "../uploads/materials/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $file_url = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    // Insert material into the database
    $stmt = $conn->prepare("INSERT INTO materials (title, description, file_url, uploaded_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $title, $description, $file_url, $uploaded_by);

    if ($stmt->execute()) {
        header("Location: buat_materi.php?success=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
