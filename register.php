<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token_aktivasi = bin2hex(random_bytes(16));
    $status = 'NONAKTIF';
    $created_at = date('Y-m-d H:i:s');

    $cek_email = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $cek_email->bind_param("s", $email);
    $cek_email->execute();
    $hasil = $cek_email->get_result();

    if ($hasil->num_rows > 0) {
        echo "<p style='color:red;'>Email sudah digunakan!</p>";
    } else {
        $query = "INSERT INTO users (nama_lengkap, email, password, token_aktivasi, status, created_at)
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $nama, $email, $password, $token_aktivasi, $status, $created_at);
        if ($stmt->execute()) {
            $link = "http://localhost/user_management/activate.php?token=" . $token_aktivasi;
            echo "<p style='color:green;'>Registrasi berhasil! Silakan aktivasi akun Anda:</p>";
            echo "<a href='$link'>$link</a>";
        } else {
            echo "<p style='color:red;'>Gagal registrasi!</p>";
        }
    }
}
?>

<form method="POST" action="">
    <h2>Register</h2>
    <label>Nama Lengkap:</label><br>
    <input type="text" name="nama_lengkap" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Daftar">
</form>
