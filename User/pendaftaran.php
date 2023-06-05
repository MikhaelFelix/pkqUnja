<?php
session_start();


if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirect ke halaman login
    header('Location: ../index.php');
    exit;
}

require "../model/function.php";

$nim = $_SESSION['nim'];

$result = mysqli_query($connection, "SELECT * FROM user WHERE nim = '$nim'");
$pecah = mysqli_fetch_assoc($result);


if ($pecah['foto_PasFoto'] > 0) {
    $gambar = $pecah['foto_PasFoto'];
} else {
    $gambar = "profile_kosong.jpeg";
}

if ($pecah['nama'] > 0) {
    $nama = $pecah['nama'];
} else {
    $nama = "Unknown";
}

if (isset($_POST['kirim_daftar'])) {
    if (tambah($_POST) > 0) {
        echo "<script>
            alert ('Data berhasil ditambahkan');
            document.location.href = 'pendaftaran.php';
        </script>";
    } else {
        echo "<script>
            alert ('Data gagal Ditambahkan');
            document.location.href = 'pendaftaran.php';
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../css/pendaftaran.css">
    <title>Pendaftaran</title>

    <style>
        body {
            display: flex;
            padding: 0;
            margin: 0;
            font-family: Poppins, sans-serif;
        }
    </style>

<body>

    <div class="container-fluid">
        <div class="p-2 m-5">
            <button class="btn btn-white border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z" />
                    <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </button>
            <span class="fs-3"><b>Profile</b></span>

            <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel" style="background-color: #006160; width: 20%;">
                <div class="offcanvas-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <img src="../img/<?= $gambar; ?>" alt="" class="rounded-circle w-50" style="box-shadow: 0px 6px 2px rgba(0, 0, 0, 0.25);"><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <p class=" fw-medium text-light py-2"><?= $nama; ?></p>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn p-0 btn-outline-light position-absolute start-100 translate-middle" data-bs-dismiss="offcanvas" aria-label="Close" style="border: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                            <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                        </svg>
                    </button>
                </div>
                <div class="offcanvas-body p-0">
                    <div class="container">
                        <div class="list_menu row">
                            <a href="pendaftaran.php" class="py-3 col-sm-10 offset-sm-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" fill="currentColor" class="bi bi-credit-card px-3" viewBox="0 0 16 16" style="color: #E09326;">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z" />
                                    <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                                </svg>Pendaftaran
                            </a>
                        </div>
                        <div class="list_menu row">
                            <a href="ngaji.php" class="py-3 col-sm-10 offset-sm-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" fill="currentColor" class="bi bi-book px-3" viewBox="0 0 16 16" style="color: #E09326;">
                                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                                </svg> Ngaji
                            </a>
                        </div>
                        <div class="list_menu row">
                            <a href="sertifikat.php" class="py-3 col-sm-10 offset-sm-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" fill="currentColor" class="bi bi-card-heading px-3" viewBox="0 0 16 16" style=" color: #E09326;">
                                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                    <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z" />
                                </svg>Sertifikat
                            </a>
                        </div>
                        <div class="list_menu row">
                            <a href="../logout.php" class="py-3 col-sm-10 offset-sm-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" fill="currentColor" class="bi bi-box-arrow-right px-3" viewBox="0 0 16 16" style="color: E09326;">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                </svg>LogOut
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container w-100 border border-black border-1 mt-3 rounded shadow-lg">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row my-5">
                        <label for="no_req" class="col-2 offset-sm-2">No Req*</label>
                        <input type=" text" name="no_req" placeholder="Input Your No Req" class="col-5" aria-label="no_req" autocomplete="off" required value="<?= $pecah['no_req']; ?>">
                    </div>

                    <div class="row mb-5">
                        <label for="foto" class="col-2 offset-sm-2"">Foto*</label>
                        <input type="file" name="foto" id="foto" class="col-5">
                    </div>


                    <div class="row mb-5">
                        <label for="nama" class="col-2 offset-sm-2">Nama*</label>
                        <input type=" text" name="nama" placeholder="Input Your Name" class="col-5" aria-label="nama" autocomplete="off" value="<?= $pecah['nama']; ?>">
                    </div>

                    <div class="row mb-5">
                        <label for="nim" class="col-2 offset-sm-2">NIM*</label>
                        <input type="text" name="nim" placeholder="Input Your NIM" class="col-5" aria-label="nim" value="<?= strtoupper($pecah['nim']); ?>">
                    </div>

                    <div class="row mb-5">
                        <label for="fakultas" class="col-2 offset-sm-2">Fakultas*</label>
                        <input type="text" name="fakultas" placeholder="Input Your Fakultas" class="col-5" aria-label="fakultas" autocomplete="off" value="<?= $pecah['fakultas']; ?>">
                    </div>

                    <div class="row mb-5">
                        <label for="prodi" class="col-2 offset-sm-2">Prodi*</label>
                        <input type="text" name="prodi" placeholder="Input Your Study Program" class="col-5" aria-label="foto" autocomplete="off" value="<?= $pecah['prodi']; ?>">
                    </div>

                    <!-- <label for="nim">nim</label><br> -->
                    <input type="hidden" name="nim" id="nim" value="<?= $pecah["nim"]; ?>">
                    <input type="hidden" name="foto_lama" value="<?= $pecah['foto_PasFoto'] ?>">

                    <div class="row mb-5">
                        <button type="submit" class="btn btn-success col-sm-1 offset-sm-8 shadow" name="kirim_daftar">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/popper.min.js"></script>
</body>

</html>