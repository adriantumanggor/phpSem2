<?php
session_start();
include('function/config.php');
include('function/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $login_result = login_user($conn, $username, $password);

    if ($login_result === true) {
        if ($_SESSION['role'] == 'mahasiswa') {
            header('Location: mahasiswa/');
        } elseif ($_SESSION['role'] == 'dosen') {
            header('Location: dosen/');
        }
        exit();
    } else {
        $error_message = $login_result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex justify-center items-center h-screen">
        <div class="w-full max-w-xs">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h1 class="text-center text-2xl mb-4"><i class="fas fa-sign-in-alt"></i> Login</h1>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700 text-sm font-bold mb-2">
                            <i class="fas fa-user"></i> Username
                        </label>
                        <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                    <?php if (isset($error_message)) : ?>
                        <p class="text-red-500 text-xs italic mt-4"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                </form>
            </div>
            <p class="text-center text-gray-500 text-xs">
                Belum punya akun? <a href="reg.php" class="text-blue-500 hover:text-blue-700">Daftar di sini</a>
            </p>
        </div>
    </div>
</body>

</html>
