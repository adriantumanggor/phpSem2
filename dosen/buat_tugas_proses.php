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
    $title = $_POST['assignment_title'];
    $description = $_POST['assignment_description'];
    $deadline = $_POST['submission_deadline'];
    $created_by = $_SESSION['id'];
    $file_url = NULL;

    // Check if a file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $target_dir = "../uploads/assignments/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $file_url = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert assignment into the database
        $stmt = $conn->prepare("INSERT INTO assignments (title, description, file_url, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $description, $file_url, $created_by);
        $stmt->execute();

        // Get the last inserted assignment ID
        $assignment_id = $stmt->insert_id;

        // Insert deadline into the deadlines table
        $stmt = $conn->prepare("INSERT INTO deadlines (assignment_id, due_date) VALUES (?, ?)");
        $stmt->bind_param("is", $assignment_id, $deadline);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        header("Location: buat_tugas.php?success=1");
        exit;
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
