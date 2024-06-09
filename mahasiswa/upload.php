<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('../function/config.php');
include('../function/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $assignment_id = $_POST['assignment_id'];
    $submitted_by = $_SESSION['id'];
    $file = $_FILES['file'];

    $target_dir = "../uploads/submissions/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            if (hasSubmitted($conn, $assignment_id, $submitted_by)) {
                // Update existing submission
                $stmt = $conn->prepare("UPDATE submissions SET file_url = ? WHERE assignment_id = ? AND submitted_by = ?");
                $stmt->bind_param("sii", $target_file, $assignment_id, $submitted_by);
            } else {
                // Insert new submission
                $stmt = $conn->prepare("INSERT INTO submissions (assignment_id, submitted_by, file_url) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $assignment_id, $submitted_by, $target_file);
            }
            if ($stmt->execute()) {
                echo "The file ". htmlspecialchars(basename($file["name"])). " has been uploaded.";
                header("Location: tugas.php");
                exit;
            } else {
                echo "Sorry, there was an error saving your submission.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
