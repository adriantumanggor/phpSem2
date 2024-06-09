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

$submissions = getAllSubmissions($conn);
?>

<?php include('header.php'); ?>

<!-- Content Area -->
<h1 class="text-2xl font-semibold mb-4">Daftar Pengumpulan Tugas</h1>

<?php if (count($submissions) > 0) : ?>
    <table class="table-auto w-full mb-4">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="px-4 py-2 text-left">Judul Tugas</th>
                <th class="px-4 py-2 text-left">Nama Mahasiswa</th>
                <th class="px-4 py-2 text-left">Tanggal Pengumpulan</th>
                <th class="px-4 py-2 text-left">File</th>
                <th class="px-4 py-2 text-left">Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($submissions as $submission) : ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($submission['assignment_title']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($submission['student_name']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($submission['submission_date']); ?></td>
                    <td class="border px-4 py-2">
                        <a href="<?php echo htmlspecialchars($submission['file_url']); ?>" class="text-blue-500 hover:text-blue-700" target="_blank">Lihat File</a>
                        <br>
                        <a href="<?php echo htmlspecialchars('download.php?file_url=' . $submission['file_url'] . '&file_name=' . $submission['file_name']); ?>" class="text-green-500 hover:text-green-700">Download File</a>
                    </td>

                    <td class="border px-4 py-2">
                        <form method="post" action="beri_nilai.php">
                            <input type="hidden" name="submission_id" value="<?php echo $submission['id']; ?>">
                            <input type="text" inputmode="numeric" name="grade" value="<?php echo htmlspecialchars($submission['grade']); ?>" class="border rounded p-1 w-24">
                            <button type="submit" class="bg-blue-500 text-white p-1 rounded hover:bg-blue-700"> <i class="fas fa-check" aria-hidden="true"></i>
                            </button>
                            <?php if ($submission['grade'] > 0) : ?>
                                <span class="text-green-500 ">Tugas sudah dinilai!</span>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table><?php else : ?>
    <p>Tidak ada tugas yang dikumpulkan.</p>
<?php endif; ?>

<?php include('footerfix.php'); ?>
</body>
</html>