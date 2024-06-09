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
?>

<?php include('header.php'); ?>

<!-- Content Area -->
<h1 class="text-2xl font-semibold mb-4">Buat Tugas</h1>

<?php if (isset($_GET['success']) && $_GET['success'] == 1) : ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" id="success-message">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">Tugas berhasil dibuat.</span>
    </div>
    <br>
    <script>
        setTimeout(function() {
            document.getElementById("success-message").style.display = "none";
        }, 3000); // 3000 adalah 3 detik
    </script>
<?php endif; ?>

<form method="post" action="buat_tugas_proses.php" enctype="multipart/form-data">
    <div class="flex flex-wrap -mx-3 mb-4">
        <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="assignment_title">
                Judul Tugas
            </label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="assignment_title" type="text" name="assignment_title" required>
        </div>
        <div class="w-full md:w-1/2 px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="assignment_description">
                Deskripsi Tugas
            </label>
            <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="assignment_description" name="assignment_description" oninput="autoResizeTextarea(this)" required></textarea>
        </div>
    </div>
    <div class="flex flex-wrap -mx-3 mb-4">
        <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="submission_deadline">
                Batas Pengumpulan
            </label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="submission_deadline" type="datetime-local" name="submission_deadline" required>
        </div>
        <div class="w-full md:w-1/2 px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="file">
                Upload File (Optional)
            </label>
            <input class="appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="file" type="file" name="file">
        </div>
    </div>
    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='kegiatan.php'">
        Kembali
    </button>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Buat Tugas
    </button>
</form>

<?php include('footerfix.php'); ?>
</body>
</html>