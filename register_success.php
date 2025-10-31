<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Berhasil</title>
</head>
<body style="font-family: Arial; text-align:center; margin-top:50px;">
    <h2 style="color:green;">✅ Registrasi Berhasil!</h2>
    <p>Akun Anda telah terdaftar dengan sukses.</p>
    <p>Untuk mengaktifkan akun, buka link berikut:</p>
    <?php
    if (isset($_GET["token"])) {
        $token = htmlspecialchars($_GET["token"]);
        echo "<code>activate.php?token=$token</code>";
    }
    ?>
    <br><br>
    <a href="login.php">➡️ Kembali ke Halaman Login</a>
</body>
</html>
