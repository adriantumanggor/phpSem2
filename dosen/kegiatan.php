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

$user_id = $_SESSION['id']; 
$materials = getAllMaterials($conn);
$tugas = getAssignmentsDosen($conn, $user_id); 

?>

<?php include('header.php'); ?>

<!-- Content Area -->
<h1 class="text-2xl font-semibold mb-4">Kegiatan Dosen</h1>
<div class="flex justify-center space-x-4 mb-4">
    <a href="buat_tugas.php" class="bg-blue-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ease-in-out font-bold">
        <i class="fas fa-edit mr-2"></i> Buat Tugas
    </a>
    <a href="buat_materi.php" class="bg-green-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-green-700 transition duration-300 ease-in-out font-bold">
        <i class="fas fa-book mr-2"></i> Buat Materi
    </a>
</div>
<br>
<br>


<h1 class="text-2xl font-semibold mb-4">Materi yang diupload</h1>

<?php if (count($materials) > 0): ?>
    <div class="grid grid-cols-1 gap-4">
        <?php foreach ($materials as $material): ?>
            <div class="bg-white shadow-md rounded p-4">
                <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($material['title']); ?></h2>
                <p class="text-gray-700"><?php echo htmlspecialchars($material['description']); ?></p>
                <p class="text-sm text-gray-500">Diupload oleh: <?php echo htmlspecialchars($material['uploaded_by']); ?> pada <?php echo htmlspecialchars($material['uploaded_at']); ?></p>
                <?php if ($material['file_url']): ?>
                    <a href="<?php echo htmlspecialchars($material['file_url']); ?>" class="text-blue-500 hover:text-blue-700" target="_blank">Lihat File</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Tidak ada materi yang tersedia.</p>
<?php endif; ?>
<br>
<br>

<h1 class="text-2xl font-semibold mb-4">Daftar Tugas Yang Dibuat</h1>
<?php if (count($tugas) > 0): ?>
    <div class="grid grid-cols-1 gap-4">
    <?php foreach ($tugas as $tugas_item) : ?>
        <div class="bg-white p-4 rounded shadow mb-5">
            <h2 class="text-xl font-bold"><?php echo htmlspecialchars($tugas_item['judul_tugas']); ?></h2>
            <p class="mt-2"><?php echo htmlspecialchars($tugas_item['deskripsi_tugas']); ?></p>
            <p class="mt-2 text-gray-600">Deadline: <?php echo htmlspecialchars($tugas_item['deadline']); ?></p>
            <p class="mt-2 text-gray-600">Dibuat oleh: <?php echo htmlspecialchars($tugas_item['dibuat_oleh']); ?></p>
        </div>
    <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Belum ada tugas yang dibuat.</p>
<?php endif; ?>

<?php include('footer.php'); ?>
