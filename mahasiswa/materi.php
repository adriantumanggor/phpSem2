<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('../function/config.php');
include('../function/functions.php');

if ($_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../error_page.php");
    exit;
}

$materials = getAllMaterials($conn);
?>

<?php include('header.php'); ?>

<!-- Content Area -->
    <h1 class="text-2xl font-semibold mb-4">Materi Pembelajaran</h1>

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

<?php include('footer.php'); ?>
