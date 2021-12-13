<?php

require_once("config.php");

if(isset($_POST["daftar"])){
    // filter data yang diinputkan
    $nama = filter_input(INPUT_POST, 'nama_toko', FILTER_SANITIZE_STRING);
    $deskripsi = filter_input(INPUT_POST, 'deskripsi_toko', FILTER_SANITIZE_STRING);


    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $nama_pemilik = filter_input(INPUT_POST, 'nama_pemilik', FILTER_SANITIZE_STRING);

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

    $jenis_kelamin = $_POST['jenis-kelamin'];

    
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // alamat dan pekerjaan
    $alamat = filter_input(INPUT_POST, 'alamat_toko', FILTER_SANITIZE_STRING);
    $nomer_hp = filter_input(INPUT_POST, 'no_telepon', FILTER_SANITIZE_STRING);

    if(array_key_exists('photo',$_FILES)){
        if($_FILES['photo']['name']){
            $temp = explode(".", $_FILES["photo"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            move_uploaded_file($_FILES['photo']['tmp_name'], "../Assets/images/pengguna/".$newfilename);
            $img = "../Assets/images/pengguna/".$newfilename;
        }
    }

    // menyiapkan query
    $sql = "INSERT INTO toko (Nama_toko, Username_toko, Email_toko, Password_toko, Nama_pemilik_toko, Foto_toko, Deskripsi_toko, Alamat_toko, No_tlp_toko, Jenis_kelamin_pemilik)
        VALUES (:Nama_toko, :Username_toko, :Email_toko, :Password_toko, :Nama_pemilik_toko, :Foto_toko, :Deskripsi_toko, :Alamat_toko, :No_tlp_toko, :Jenis_kelamin_pemilik)
    ";

    $stmt = $db->prepare($sql);

    $saved = $stmt->execute([
        ":Nama_toko" => $nama, 
        ":Username_toko" => $username, 
        ":Email_toko" => $email, 
        ":Password_toko" => $password, 
        ":Nama_pemilik_toko" => $nama_pemilik, 
        ":Foto_toko" => $img, 
        ":Deskripsi_toko" => $deskripsi, 
        ":Alamat_toko" => $alamat, 
        ":No_tlp_toko" => $nomer_hp, 
        ":Jenis_kelamin_pemilik" => $nama_pemilik
    ]);

    if($saved) header('Location:login.php');


}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Daftar</title>
  </head>
  <body style="overflow:hidden">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-6" style="width:40vw">
                <div class="container-md ms-5">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <h3 class="mt-2 mb-2">Daftar Akun</h3>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="nama_toko">Nama Toko</label>
                                <input type="text" name="nama_toko" class="form-control" placeholder="nama toko">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="desk_toko">Deskripsi Toko</label>
                                <div class="form-floating">
                                    <textarea class="form-control" name="deskripsi_toko" placeholder="masukkan deskripsi Toko" id="floatingTextarea2" style="height: 70px"></textarea>
                                    <label for="floatingTextarea2">Deskripsi Toko</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="nama_pemilik">nama pemilik toko</label>
                                <input type="text" name="nama_pemilik" class="form-control" placeholder="nama pemilik toko">    
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="alamat_toko">alamat toko</label>
                                <input type="text" name="alamat_toko" class="form-control" placeholder="alamat toko">  
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis-kelamin" id="laki-laki" value="laki-laki">
                                    <label class="form-check-label" for="laki-laki">laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis-kelamin" id="perempuan" value="perempuan">
                                    <label class="form-check-label" for="perempuan">perempuan</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="username"> 
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="password">password</label>
                                <input type="password" name="password" class="form-control" placeholder="password"> 
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="no_telepon">no telepon</label>
                                <input type="text" name="no_telepon" class="form-control" placeholder="no telepon"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="photo">Foto</label>
                                <input type="file" name="photo" class="form-control"> 
                            </div>
                            <div class="col d-flex align-items-center justify-content-center pt-3">
                                <input type="submit" name="daftar" value="daftar" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-6 image-samping"></div>
        </div>
    </div>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>