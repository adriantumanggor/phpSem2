<?php
// Mulai sesi
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

include('../function/config.php');
include('../function/functions.php');

// Pengecekan role pengguna
if ($_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../error_page.php");
    exit;
}

$dosenList = getDosenList($conn);
?>


<?php include('header.php'); ?>

<h1 class="text-2xl font-semibold mb-4 ">Dashboard Mahasiswa</h1>
    <p>Selamat datang, <?php echo $_SESSION['username']; ?>!</p>

<div class="container mx-auto py-6">
    <h1 class="text-xl font-semibold mb-4">Daftar Dosen</h1>
    <ul class="divide-y divide-gray-200">
        <?php foreach ($dosenList as $dosen) : ?>
            <li class="py-4 flex justify-between items-center">
                <div class="flex flex-col">
                    <span class="text-lg"><?php echo $dosen['nama']; ?></span>
                    <span class="text-gray-600"><?php echo $dosen['email']; ?></span>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include('footer.php'); ?>