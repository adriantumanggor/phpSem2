<?php
// Mulai sesi
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

$mahasiswaList = getMahasiswaList($conn);
?>


<?php include('header.php'); ?>

<h1 class="text-2xl font-semibold mb-4 ">Dashboard Mahasiswa</h1>
    <p>Selamat datang, <?php echo $_SESSION['username']; ?>!</p>

<div class="container mx-auto py-6">
    <h1 class="text-xl font-semibold mb-4">Daftar mahasiswa</h1>
    <ul class="divide-y divide-gray-200">
        <?php foreach ($mahasiswaList as $mahasiswa) : ?>
            <li class="py-4 flex justify-between items-center">
                <div class="flex flex-col">
                    <span class="text-lg"><?php echo $mahasiswa['nama']; ?></span>
                    <span class="text-gray-600"><?php echo $mahasiswa['email']; ?></span>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include('footerfix.php'); ?>
</body>
</html>