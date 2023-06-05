<?php

//koneksi
$connection = mysqli_connect('localhost', 'root', '', 'pkq');

function query($query)
{
    global $connection;
    $result = mysqli_query($connection, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function regis($data)
{
    global $connection;
    $nimRegis = strtolower($data["nimRegis"]);
    $pwRegis = mysqli_escape_string($connection, $data['pwRegis']);

    //cek email sudah ada atau belum
    $cek_email =  mysqli_query($connection, "SELECT nim FROM user WHERE nim = '$nimRegis'");
    if (mysqli_fetch_assoc($cek_email)) {
        echo "<script>
            alert('Username sudah terdaftar');
            document.location.href = 'index.php';
        </script>";
        return false;
    }

    $save = "INSERT INTO user (nim, password) VALUES ('$nimRegis', '$pwRegis')";
    mysqli_query($connection, $save);

    return mysqli_affected_rows($connection);
}

function tambah($tambah)
{
    global $connection;

    // $nim = strtolower($tambah['nim']);
    $no_req = htmlspecialchars($tambah['no_req']);
    $nama = htmlspecialchars($tambah['nama']);
    $fakultas = htmlspecialchars($tambah['fakultas']);
    $prodi = htmlspecialchars($tambah['prodi']);
    $nim = htmlspecialchars(strtolower($tambah['nim']));
    $foto_lama = htmlspecialchars($tambah['foto_lama']);

    //cek user upload gambar atau tidak
    if ($_FILES['foto']['error'] === 4) {
        $foto = $foto_lama;
    } else {
        $foto = upload();
    }



    $insert =  "UPDATE user SET nim = '$nim', no_req = '$no_req', nama = '$nama', fakultas = '$fakultas', prodi = '$prodi', foto_PasFoto = '$foto' WHERE nim = '$nim'";
    mysqli_query($connection, $insert);
    return mysqli_affected_rows($connection);
}

function upload()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $lokasi_awal = $_FILES['foto']['tmp_name'];

    // //cek apakah tidak ada gambar
    if ($error ===   4) {
        echo "<script>
            alert ('Pilih foto terlebih dahulu');
        </script>";
        return false;
    }
    //cek apakah yang diupload adalah gambar
    $ekstensiValid = ['jpg', 'jpeg', 'png', 'jfif'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiValid)) {
        echo "<script>
        alert ('Yang diupload bukan gambar');   
    </script>";
        return false;
    }

    if ($ukuranFile > 500000) {
        echo "<script>
    alert ('Ukuran gambar terlalu  besar');
        </script>";
        return false;
    }

    $namaFileBaru = date('G_i_s') . $namaFile;
    $namaFile = $namaFileBaru;
    move_uploaded_file($lokasi_awal, '../img/' . $namaFileBaru);

    return $namaFile;
}

function cari($keyword)
{
    $query = "SELECT * FROM user WHERE no_req LIKE '%$keyword%' OR nama LIKE '%$keyword%' OR nim LIKE '%$keyword%' OR fakultas LIKE '%$keyword%' OR prodi LIKE '%$keyword%'";


    return query($query);
}

function ajukan($ajukan)
{
    global $connection;

    $no_req = htmlspecialchars($ajukan['no_req']);
    $nama = htmlspecialchars($ajukan['nama']);
    $nim = htmlspecialchars(strtolower($ajukan['nim']));

    // upload gambar atau tidak
    $foto = upload();
    if (!$foto) {
        return false;
    }


    $insert =  "INSERT INTO validasi VALUES ('$no_req', '$nama', '$nim', '$foto')";
    mysqli_query($connection, $insert);
    return mysqli_affected_rows($connection);
}
