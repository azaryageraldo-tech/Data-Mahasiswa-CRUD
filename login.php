<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "akademik1";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Gagal koneksi ke database");
}

$username = $_POST['username'];
$password = md5($_POST['password']);

$query = "SELECT * FROM login WHERE username='$username' AND password='$password'";
$result = $koneksi->query($query);

if ($result->num_rows > 0) {
    header ("Location:index.php");
    echo "Login successful!";
} else {
    echo "Login failed. Invalid username or password.";
}
$koneksi->close();
?>