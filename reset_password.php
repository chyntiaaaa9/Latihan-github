<?php
include 'koneksi.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Cek token di database
    $query = $conn->prepare("SELECT * FROM users WHERE token_reset = ?");
    $query->bind_param("s", $token);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 0) {
        die("<p style='color:red;'>Token reset tidak valid.</p>");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password_baru = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $update = $conn->prepare("UPDATE users SET password = ?, token_reset = NULL WHERE token_reset = ?");
        $update->bind_param("ss", $password_baru, $token);
        $update->execute();

        echo "<p style='color:green;'>Password berhasil diubah!</p>";
        echo "<p><a href='login.php'>Login sekarang</a></p>";
        exit;
    }
} else {
    die("<p style='color:red;'>Token tidak ditemukan.</p>");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Form Reset Password</h2>
    <form method="POST" action="">
        <label>Password Baru:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Ubah Password">
    </form>
</body>
</html>
