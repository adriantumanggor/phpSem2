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
<h1 class="text-2xl font-semibold mb-4">Buat Materi</h1>

<?php if (isset($_GET['success']) && $_GET['success'] == 1) : ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">Materi berhasil dibuat.</span>
    </div>
<?php endif; ?>

<form method="post" action="buat_materi_proses.php" enctype="multipart/form-data">
    <div class="flex flex-wrap -mx-3 mb-4">
        <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="material_title">
                Judul Materi
            </label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="material_title" type="text" name="material_title" required>
        </div>
        <div class="w-full md:w-1/2 px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="material_description">
                Deskripsi Materi
            </label>
            <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="material_description" name="material_description" oninput="autoResizeTextarea(this)" required></textarea>
        </div>
    </div>
    <div class="flex flex-wrap -mx-3 mb-4">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="file">
                Upload File (Optional)
            </label>
            <input class="appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="file" type="file" name="file">
        </div>
    </div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Buat Materi
    </button>
</form>


<?php include('footerfix.php'); ?>
<script>
    function autoResizeTextarea(textarea) {
        textarea.style.height = 'auto'; // Reset height to auto
        textarea.style.height = (textarea.scrollHeight + 2) + 'px'; // Set height to scrollHeight + 2 for padding
    }
</script>
</body>
</html>