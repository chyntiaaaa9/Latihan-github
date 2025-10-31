<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Cek apakah email ada di database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Buat token reset acak
        $token = md5(uniqid(rand(), true));

        // Simpan token ke database
        $update = $conn->prepare("UPDATE users SET token_reset = ? WHERE email = ?");
        $update->bind_param("ss", $token, $email);
        $update->execute();

        echo "<p style='color:green;'>Permintaan reset berhasil!<br>
        Gunakan link berikut untuk ubah password:<br>
        <a href='reset_password.php?token=$token'>Klik di sini untuk reset password</a></p>";
    } else {
        echo "<p style='color:red;'>Email tidak ditemukan.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password</title>
</head>
<body>
    <h2>Form Lupa Password</h2>
    <form method="POST" action="">
        <label>Masukkan Email Anda:</label><br>
        <input type="email" name="email" required><br><br>
        <input type="submit" value="Kirim Permintaan Reset">
    </form>

    <p><a href="login.php">Kembali ke Login</a></p>
</body>
</html>
