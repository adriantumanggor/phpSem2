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

$tugas = getAssignments($conn);
$student_id = $_SESSION['id'];
?>

<?php include('header.php'); ?>

    <h1 class="text-2xl font-semibold mb-4">Tugas</h1>
    <p>Selamat datang, <?php echo $_SESSION['username']; ?>! Berikut adalah daftar tugas yang tersedia:</p>
    <br>
    <br>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($tugas as $tugas_item) : ?>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-bold"><?php echo $tugas_item['judul_tugas']; ?></h2>
                <p class="mt-2"><?php echo $tugas_item['deskripsi_tugas']; ?></p>
                <p class="mt-2 text-gray-600">Deadline: <?php echo $tugas_item['deadline']; ?></p>
                <p class="mt-2 text-gray-600">Dibuat oleh: <?php echo $tugas_item['dibuat_oleh']; ?></p>

                <?php if (hasSubmitted($conn, $tugas_item['assignment_id'], $student_id)) : ?>
                    <?php 
                    $submission = getSubmission($conn, $tugas_item['assignment_id'], $student_id);
                    ?>
                    <p class="mt-4 text-green-500">Anda sudah mengupload tugas ini.</p>
                    <p class="mt-2 text-gray-600">Nilai: <?php echo $submission['grade'] !== null ? $submission['grade'] : 'Belum diberikan'; ?></p>
                    <form action="upload.php" method="post" enctype="multipart/form-data" class="mt-4">
                        <input type="hidden" name="assignment_id" value="<?php echo $tugas_item['assignment_id']; ?>">
                        <label for="file" class="block text-gray-700">Update file tugas:</label>
                        <input type="file" id="file" name="file" class="mt-2 p-2 border border-gray-300 rounded w-full" required>
                        <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload Ulang Tugas</button>
                    </form>
                <?php else : ?>
                    <form action="upload.php" method="post" enctype="multipart/form-data" class="mt-4">
                        <input type="hidden" name="assignment_id" value="<?php echo $tugas_item['assignment_id']; ?>">
                        <label for="file" class="block text-gray-700">Pilih file tugas:</label>
                        <input type="file" id="file" name="file" class="mt-2 p-2 border border-gray-300 rounded w-full" required>
                        <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload Tugas</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

<?php include('footer.php'); ?>
