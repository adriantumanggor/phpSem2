<?php
include('function/config.php');
include('function/functions.php');

// Set pesan awal menjadi string kosong
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];

    // Panggil fungsi register_user untuk mendaftarkan pengguna
    $message = register_user($conn, $username, $password, $role, $full_name, $email);

    // Jika registrasi berhasil, redirect ke halaman login setelah 1 detik
    if (empty($message)) {
        echo '<meta http-equiv="refresh" content="1;url=login.php">';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white rounded-md overflow-hidden shadow-md">
            <div class="p-4">
                <h1 class="text-2xl text-center mb-4"><i class="fas fa-user-plus"></i> Registrasi</h1>
                <?php if (!empty($message)): ?>
                    <div class="message-box bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-user"></i> Username</label>
                        <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="role" class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-graduation-cap"></i> Role</label>
                        <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="full_name" class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-user"></i> Nama Lengkap</label>
                        <input type="text" name="full_name" id="full_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"><i class="fas fa-user-plus"></i> Registrasi</button>
                </form>
            </div>
            <div class="bg-gray-100 border-t border-gray-200 text-center py-4">
                <p>Sudah punya akun? <a href="login.php" class="text-blue-500 hover:text-blue-700">Login di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
