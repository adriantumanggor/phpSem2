    CREATE DATABASE IF NOT EXISTS elearning;
    USE elearning;

    -- Tabel untuk pengguna (mahasiswa dan dosen)
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('mahasiswa', 'dosen') NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL
    );

    -- Tabel untuk materi pembelajaran
    CREATE TABLE IF NOT EXISTS materials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        file_url VARCHAR(255),
        uploaded_by INT,
        uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (uploaded_by) REFERENCES users(id)
    );

    -- Tabel untuk tugas
    CREATE TABLE IF NOT EXISTS assignments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        file_url VARCHAR(255),
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES users(id)
    );

    -- Tabel untuk tenggat waktu
    CREATE TABLE IF NOT EXISTS deadlines (
        id INT AUTO_INCREMENT PRIMARY KEY,
        assignment_id INT,
        due_date DATETIME,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (assignment_id) REFERENCES assignments(id)
    );

    -- Tabel untuk pengumpulan tugas
    CREATE TABLE IF NOT EXISTS submissions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        assignment_id INT,
        file_url VARCHAR(255),
        submitted_by INT,
        submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        grade INT DEFAULT NULL,
        FOREIGN KEY (assignment_id) REFERENCES assignments(id),
        FOREIGN KEY (submitted_by) REFERENCES users(id)
    );
