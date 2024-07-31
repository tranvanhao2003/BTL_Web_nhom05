<?php
session_start(); 

if (isset($_SESSION["register_error"])) {
    $register_error = $_SESSION["register_error"];
    unset($_SESSION["register_error"]); 
}

if (isset($_SESSION["register_success"])) {
    $register_success = $_SESSION["register_success"];
    unset($_SESSION["register_success"]); 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
        <form action="register_process.php" method="post">
            <p class="text-2xl font-bold text-center mb-6">Đăng ký</p>
            <div class="mb-4">
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    type="text" name="username" placeholder="Tên đăng nhập" required>
            </div>
            <div class="mb-4">
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    type="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <div class="mb-4">
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
            </div>
            <?php if (isset($register_error)): ?>
            <p class="text-red-500 text-xs italic mb-4"><?php echo $register_error; ?></p>
            <?php endif; ?>
            <?php if (isset($register_success)): ?>
            <p class="text-green-500 text-xs italic mb-4"><?php echo $register_success; ?></p>
            <?php endif; ?>
            <div class="flex items-center justify-between">
                <div>
                    <p class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        <a class="text-blue-500 hover:text-blue-700 text-sm" href="./login.php">Đã có tài khoản</a>
                    </p>
                </div>
                <button
                    class="justify-end bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Đăng ký
                </button>
            </div>
        </form>
    </div>

</body>

</html>