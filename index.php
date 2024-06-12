<?php
$host      = "localhost";
$user      = "root";
$pass      = "";
$db        = "akademik1";

$koneksi   = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Gagal koneksi ke database");
}
$nim       = "";
$nama      = "";
$jurusan    = "";
$fakultas  = "";
$sukses    = "";
$error     = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op    == 'delete') {
    $id     = $_GET['id'];
    $sql1   = "DELETE FROM mahasiswa WHERE id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id       = $_GET['id'];
    $sql1     = "SELECT * FROM mahasiswa WHERE id = '$id'";
    $q1       = mysqli_query($koneksi, $sql1);
    $r1       = mysqli_fetch_array($q1);
    $nim      = $r1['nim'];
    $nama     = $r1['nama'];
    $jurusan   = $r1['jurusan'];
    $fakultas = $r1['fakultas'];

    if ($nim == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) {
    $nim      = $_POST['nim'];
    $nama     = $_POST['nama'];
    $jurusan   = $_POST['jurusan'];
    $fakultas = $_POST['fakultas'];

    if ($nim && $nama && $jurusan && $fakultas) {
        if ($op == 'edit') {
            $sql1   = "UPDATE mahasiswa SET nim = '$nim', nama='$nama', 
            jurusan = '$jurusan', fakultas='$fakultas' WHERE id = '$id'";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else {
            $sql1   = "INSERT INTO mahasiswa (nim, nama, jurusan, fakultas) 
            VALUES ('$nim', '$nama', '$jurusan', '$fakultas')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error  = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silahkan masukkan semua datanya";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATA MAHASISWA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <style>
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header header-bg">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Jurusan</label>
                        <select class="form-control" name="jurusan" id="jurusan">
                            <option value="">- Pilih Jurusan -</option>

                            <option value="sistem_informasi" <?php if ($jurusan == "sistem_informasi") 
                            echo "selected" ?>>sistem informasi</option>

                            <option value="informatika" <?php if ($jurusan == "informatika") 
                            echo "selected" ?>>informatika</option>

                            <option value="teknik_komputer" <?php if ($jurusan == "teknik_komputer") 
                            echo "selected" ?>>teknik komputer</option>

                            <option value="bisnis_digital" <?php if ($jurusan == "bisnis_digital") 
                            echo "selected" ?>>bisnis digital</option>

                            <option value="manajemen_ritel" <?php if ($jurusan == "manajemen_ritel") 
                            echo "selected" ?>>manajemen ritel</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Fakultas</label>
                        <select class="form-control" name="fakultas" id="fakultas">
                            <option value="">- Pilih Fakultas -</option>
                            <option value="teknologi_informasi" <?php if ($fakultas == "teknologi_informasi") 
                            echo "selected" ?>>Teknologi Informasi</option>
                            
                            <option value="manajemen_bisnis" <?php if ($fakultas == "manajemen_bisnis") 
                            echo "selected" ?>>Manajemen dan Bisnis</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary btn-margin" />
                        <a href="index.php" class="btn btn-secondary btn-margin">Batal</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header header-bg">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM mahasiswa ORDER BY id DESC ";
                        $q2   = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id       = $r2['id'];
                            $nim      = $r2['nim'];
                            $nama     = $r2['nama'];
                            $jurusan   = $r2['jurusan'];
                            $fakultas = $r2['fakultas'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nim ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $jurusan ?></td>
                                <td scope="row"><?php echo $fakultas ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>" class="btn btn-warning btn-margin">Edit</a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" 
                                    onclick="return confirm('Apakah Mau Delete Data?')" class="btn btn-danger btn-margin">Hapus</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
