<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM users WHERE email=?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if ($user['status'] != 'AKTIF') {
            echo "<p style='color:red;'>Akun belum diaktifkan!</p>";
        } elseif (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['nama_lengkap'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<p style='color:red;'>Password salah!</p>";
        }
    } else {
        echo "<p style='color:red;'>Email tidak ditemukan!</p>";
    }
}
?>

<form method="POST" action="">
    <h2>Login</h2>
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Login"><br><br>

    <a href="forgot_password.php">Forgot Password?</a>
</form>
