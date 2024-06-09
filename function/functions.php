<?php
function register_user($conn, $username, $password, $role, $full_name, $email)
{
    if (empty($username) || empty($password) || empty($role) || empty($full_name) || empty($email)) {
        return "Semua kolom harus diisi.";
    } else {
        // Pengecekan apakah username sudah digunakan
        $sql_check = "SELECT id FROM users WHERE username = '$username'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            return "Username sudah digunakan.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password, role, full_name, email) VALUES ('$username', '$hashed_password', '$role', '$full_name', '$email')";

            if ($conn->query($sql) === TRUE) {
                header("refresh:2;url=login.php");

                return "Registrasi berhasil!";
            } else {
                return "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

function login_user($conn, $username, $password)
{
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            return true;
        } else {
            return "Password salah.";
        }
    } else {
        return "Username tidak ditemukan.";
    }
}

function getAllAssignments($conn)
{
    $assignments = array();

    // Query untuk mengambil semua tugas
    $sql = "SELECT * FROM assignments";
    $result = $conn->query($sql);

    // Memeriksa jika ada hasil dari query
    if ($result->num_rows > 0) {
        // Menyimpan setiap baris hasil query ke dalam array $assignments
        while ($row = $result->fetch_assoc()) {
            $assignments[] = $row;
        }
    }

    return $assignments;
}


// function getAssignments($conn) {
//     $sql = "SELECT a.id AS assignment_id, a.title AS judul_tugas, a.description AS deskripsi_tugas, 
//                    d.due_date AS deadline, u.full_name AS dibuat_oleh
//             FROM assignments a
//             JOIN deadlines d ON a.id = d.assignment_id
//             JOIN users u ON a.created_by = u.id
//             ORDER BY d.due_date DESC";
//     $result = $conn->query($sql);
//     $assignments = [];
    
//     if ($result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             $assignments[] = $row;
//         }
//     }
    
//     return $assignments;
// }
function getAssignments($conn) {
    $sql = "SELECT a.id as assignment_id, a.title as judul_tugas, a.description as deskripsi_tugas, 
                   d.due_date as deadline, u.username as dibuat_oleh 
            FROM assignments a
            LEFT JOIN deadlines d ON a.id = d.assignment_id
            LEFT JOIN users u ON a.created_by = u.id";
    $result = $conn->query($sql);

    $assignments = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $assignments[] = $row;
        }
    }
    return $assignments;
}


// function hasSubmitted($conn, $assignment_id, $student_id) {
//     $sql = "SELECT * FROM submissions WHERE assignment_id = ? AND submitted_by = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param('ii', $assignment_id, $student_id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     return $result->num_rows > 0;
// }
function hasSubmitted($conn, $assignment_id, $student_id) {
    $sql = "SELECT * FROM submissions WHERE assignment_id = ? AND submitted_by = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $assignment_id, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}


// function getSubmission($conn, $assignment_id, $student_id) {
//     $sql = "SELECT * FROM submissions WHERE assignment_id = ? AND submitted_by = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param('ii', $assignment_id, $student_id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     return $result->fetch_assoc();
// }

function getSubmission($conn, $assignment_id, $student_id) {
    $sql = "SELECT * FROM submissions WHERE assignment_id = ? AND submitted_by = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $assignment_id, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

// Fungsi untuk mengunggah tugas
function uploadSubmission($conn, $assignment_id, $submitted_by, $file_url) {
    $stmt = $conn->prepare("INSERT INTO submissions (assignment_id, file_url, submitted_by) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $assignment_id, $file_url, $submitted_by);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// functions.php

function getAllMaterials($conn) {
    $sql = "SELECT m.title, m.description, m.file_url, m.uploaded_at, u.full_name AS uploaded_by
            FROM materials m
            JOIN users u ON m.uploaded_by = u.id
            ORDER BY m.uploaded_at ASC";
    $result = $conn->query($sql);
    $materials = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $materials[] = $row;
        }
    }
    
    return $materials;
}

function getAllSubmissions($conn) {
    $sql = "SELECT s.id, a.title AS assignment_title, u.full_name AS student_name, s.submission_date, s.file_url, s.grade
            FROM submissions s
            JOIN assignments a ON s.assignment_id = a.id
            JOIN users u ON s.submitted_by = u.id
            ORDER BY s.submission_date DESC";
    $result = $conn->query($sql);
    $submissions = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $submissions[] = $row;
        }
    }

    return $submissions;
}

function downloadFile($fileUrl, $customFilename = null) {
    $filename = basename($fileUrl);
    if ($customFilename) {
        $filename = $customFilename;
    }
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Type: application/octet-stream");
    readfile($fileUrl);
    exit;
}
function getAssignmentsDosen($conn, $user_id) {
    $sql = "SELECT a.id as assignment_id, a.title as judul_tugas, a.description as deskripsi_tugas, 
                   d.due_date as deadline, u.username as dibuat_oleh 
            FROM assignments a
            LEFT JOIN deadlines d ON a.id = d.assignment_id
            LEFT JOIN users u ON a.created_by = u.id
            WHERE a.created_by = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $assignments = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $assignments[] = $row;
        }
    }
    return $assignments;
}

// functions.php


// Fungsi untuk mendapatkan daftar dosen

// Fungsi untuk mendapatkan daftar dosen
function getDosenList($conn) {
    $sql = "SELECT id, full_name, email FROM users WHERE role = 'dosen'";
    $result = $conn->query($sql);

    $dosenList = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dosenList[] = array(
                'id' => $row['id'],
                'nama' => $row['full_name'],
                'email' => $row['email']
            );
        }
    }
    return $dosenList;
}

function getMahasiswaList($conn) {
    $sql = "SELECT id, full_name, email FROM users WHERE role = 'mahasiswa'";
    $result = $conn->query($sql);

    $mahasiswaList = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mahasiswaList[] = array(
                'id' => $row['id'],
                'nama' => $row['full_name'],
                'email' => $row['email']
            );
        }
    }
    return $mahasiswaList;
}

?>
