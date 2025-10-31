<?php
include 'koneksi.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $query = $conn->prepare("SELECT * FROM users WHERE token_aktivasi=?");
    $query->bind_param("s", $token);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['status'] != 'AKTIF') {
            $update = $conn->prepare("UPDATE users SET status='AKTIF', token_aktivasi=NULL WHERE token_aktivasi=?");
            $update->bind_param("s", $token);
            $update->execute();
            echo "<p style='color:green;'>Akun berhasil diaktifkan!</p>";
            echo "<a href='login.php'>Login Sekarang</a>";
        } else {
            echo "<p style='color:orange;'>Akun sudah aktif sebelumnya.</p>";
        }
    } else {
        echo "<p style='color:red;'>Token tidak valid!</p>";
    }
}
?>
