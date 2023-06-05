<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: User/pendaftaran.php");
    exit;
}

if (isset($_SESSION['login2'])) {
    header("Location: admin/peserta.php");
    exit;
}

require 'model/function.php';

if (isset($_POST['signUp'])) {
    if (regis($_POST) > 0) {
        echo "<script>
            alert ('User Baru Berhasil Ditambahkan');
            document.location.href = 'index.php';
        </script>";
    }
}

if (isset($_POST['signIn'])) {
    $nimLogin = strtolower($_POST["nimLogin"]);
    $pwLogin = mysqli_escape_string($connection, $_POST['pwLogin']);
    $result = mysqli_query($connection, "SELECT * FROM user WHERE nim = '$nimLogin'");

    if ($nimLogin == 'admin' && $pwLogin == 'admin123') {
        $_SESSION["login2"] = true;
        header("Location: admin/peserta.php");
        exit;
    }
    //cek username 
    elseif (mysqli_num_rows($result) === 1) {

        //cek pasword
        $row = mysqli_fetch_assoc($result);

        if ($pwLogin == $row["password"]) {
            $_SESSION["login"] = true;
            $_SESSION['nim'] = $nimLogin;
            // $nim = $row['nim'];
            header("Location: User/pendaftaran.php");
            exit;
        }
    }
    echo "<script>
            alert ('Email / Password salah');
            document.location.href = 'index.php';
        </script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>Document</title>

    <style>
        body {
            font-family: Poppins, sans-serif;
            margin: 0;
            padding: 0;
            width: auto;
        }

        form .namaMasukan {
            width: 610px;
            background: transparent;
            outline: none;
            border: none;
            border-bottom: 2px solid white;
            color: white;
        }

        form .namaMasukan::placeholder {
            color: white;
        }
    </style>

</head>

<body>
    <div style="width: 100%;" class="d-flex align-items-strech">
        <div class=" position-relative top-0 bottom-0 w-25 bg-white">
            <div class=" container position-fixed w-25">
                <div class="d-flex justify-content-start mt-3">
                    <img src="img/logo1.png" alt="" width="25%">
                </div>

                <div class="mt-4">
                    <h5>Welcome To <b>SIS PKQ UNJA</b></h5>
                </div>

                <div class="mt-4">
                    <ul class="nav nav-underline " id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id=" login-tab" data-bs-toggle="tab" data-bs-target="#login-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"><b>LOGIN</b></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#register-tab-pane" type="button" role="tab" aria-controls="register-tab-pane" aria-selected="false"><b>REGISTER</b></button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="login-tab-pane" role="tabpanel" aria-labelledby="login-tab" tabindex="0">
                            <form action="" method="post" class="mt-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control border-0 shadow rounded" maxlength="10" id="floatingInput" placeholder="NIM" autocomplete="off" name="nimLogin">
                                    <label for="floatingInput">NIM</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" class="form-control border-0 shadow rounded" id="floatingPassword" placeholder="Password" name="pwLogin" maxlength="8">
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <div class="mt-3">
                                    <a href="#" class="text-decoration-none">
                                        <p class="text-end">Forget Password ?</p>
                                    </a>
                                </div>
                                <button type="submit" class="button1 w-100 rounded" name="signIn">Sign In</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="register-tab-pane" role="tabpanel" aria-labelledby="register-tab" tabindex="0"">
                        <form action="" method="post" class="mt-4">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0 shadow rounded" id="floatingInput" placeholder="NIM" autocomplete="off" name="nimRegis" required maxlength="10">
                                <label for="floatingInput">NIM</label>
                            </div>
                            <div class="mt-1">
                                <p class=" ps-3">Nim cannot be changed</p>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control border-0 shadow rounded" id="floatingPassword" placeholder="Password" name="pwRegis" maxlength="8">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="mt-1">
                                <p class=" ps-3">Must be least 8 characters</p>
                            </div>
                            <button type="submit" class="button1 w-100 rounded mt-2" name="signUp">Sign Up</button>
                            <button type="submit" class="button2 w-100 rounded mt-3"><span class="iconify" data-icon="devicon:google" data-width="20" data-height="20"></span> Sign up with google</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="position-relative w-75 bg-white">
            <nav id="navbar-example2" class="navbar bg-transparent px-3 position-sticky sticky-md-top d-flex justify-content-center">
                <ul class="nav nav-underline">
                    <li class="nav-item px-3">
                        <a class="nav-link link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="#scrollspyHeading1"><b>Home</b></a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="#scrollspyHeading2"><b>About</b></a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="#scrollspyHeading3"><b>Contact</b></a>
                    </li>
                </ul>
            </nav>
            <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">
                <div id="scrollspyHeading1" class="w-100">
                    <img src="img/Home1.png" alt="" class="img-fluid">
                </div>
                <div id="scrollspyHeading2">
                    <div class="container p-5 border border-top" style="background: linear-gradient(to right   , #134e5e, #71b280);">
                        <div class="row">
                            <div class="col-4">
                                <h4 class="text-white"><b>SELAMAT DATANG DI WEBSITE</b></h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                            </div>
                            <div class="col-8 text-end">
                                <p class="text-white">Tempat di mana Anda dapat memanfaatkan Sistem Khatam Al-Quran untuk mencapai prestasi spiritual.Kami bangga menyajikan sistem Khatam Al-Quran yang inovatif, memberikan kemudahan dalam menyelesaikan khataman Al-Quran secara efisien dan terorganisir.Dengan sistem kami, Anda dapat dengan mudah melacak dan mengelola kemajuan khataman Al-Quran Anda secara online, di mana pun dan kapan pun.Kami memahami pentingnya penghargaan dan pengakuan atas prestasi Anda.</p>
                            </div>
                        </div>

                        <div class="d-flex container justify-content-around mt-3" style="width: 90%;">
                            <div class="align-self-end ms-auto">
                                <img src="img/web/gambar.png" alt="" class="img-fluid">
                            </div>
                            <div class="align-self-end ms-auto">
                                <img src="img/web/gambar2.png" alt="" class="img-fluid">
                            </div>
                            <div class="ms-1">
                                <img src="img/web/gambar3.png" alt="" class="img-fluid">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <p class="text-white"> Oleh karena itu, kami menawarkan layanan pembuatan sertifikat Khatam Al-Quran yang dapat Anda peroleh setelah menyelesaikan khataman.Kami bangga memberikan sertifikat yang berkualitas tinggi dan indah, sebagai tanda apresiasi atas usaha dan dedikasi Anda dalam menghafal dan memahami Al-Quran.Kami berkomitmen untuk menyediakan pengalaman yang luar biasa bagi pengguna kami, baik dalam menyelesaikan khataman Al-Quran maupun mendapatkan sertifikat yang mengesankan.Terhubunglah dengan komunitas kami, berbagi prestasi Anda, dan biarkan kami menjadi bagian dari perjalanan spiritual Anda dalam menguasai Al-Quran.Dengan Sistem Khatam Al-Quran kami, kami berharap dapat memberikan motivasi dan dorongan bagi Anda untuk terus meningkatkan hubungan Anda dengan Kitab Suci.Kami percaya bahwa setiap khataman Al-Quran adalah pencapaian luar biasa, dan melalui website kami, kami ingin memberikan penghargaan yang layak dan memberikan inspirasi bagi orang-orang untuk mengejar kesempurnaan Al-Quran.</p>
                            </div>

                        </div>

                    </div>
                </div>

                <div id="scrollspyHeading3">
                    <div class="container border border-top p-5 " style="background: linear-gradient(to right   , #134e5e, #71b280);">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h4 class="text-white text-start"><b>KONTAK</b></h4>
                            </div>
                        </div>
                        <div class="container d-flex justify-content-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-envelope" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                            </svg>
                            <p class="fw-bold text-black ps-5">Sispkqunja@ac.id</p>
                        </div>
                        <div class="container d-flex justify-content-start mt-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-telephone" viewBox="0 0 16 16">
                                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                            </svg>
                            <p class="fw-bold text-black ps-5">+628228639219</p>
                        </div>
                        <div class="container d-flex justify-content-start mt-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            </svg>
                            <p class="fw-bold text-black ps-5 w-50">9GJ8+M9Q, Mendalo Darat, Kec. Jambi Luar Kota,
                                Kabupaten Muaro Jambi, Jambi 36657</p>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-5">
                                <h4 class="text-white text-start"><b>Kolom Masukan</b></h4>
                            </div>
                        </div>
                        <div class="inputMasukan mt-4">
                            <form action="" method="post">
                                <input type="text" class="namaMasukan" id="namaMasukan" placeholder="Nama"><br>
                                <input type="text" class="namaMasukan mt-5" id="mailMasukan" placeholder="E-mail"><br>
                                <input type="text" class="namaMasukan mt-5" id="telpMasukan" placeholder="Telepon"><br>
                                <input type="text" class="namaMasukan mt-5" id="pesanMasukan" placeholder="Pesan"><br>
                                <div class="row my-5">
                                    <div class="col-9 d-flex justify-content-end">
                                        <button class="btn btn-dark" type="submit" style="width: 200px;">Kirim Pesan -</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="js/bootstrap.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</body>

</html>