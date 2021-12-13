<?php


require_once("config.php");

if(isset($_POST['login'])){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // if($username == 'admin'){
    //     $sql = "SELECT * FROM admin WHERE Username_admin=:username";
    // }else{
    //     $sql = "SELECT * FROM pelanggan WHERE Username_pelanggan=:username";
    // }

    $sql = "SELECT * FROM toko WHERE Username_toko=:username";
    
    $stmt = $db->prepare($sql);
    
    // bind parameter ke query
    $params = array(
        ":username" => $username
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    

    // jika user terdaftar
    if($user){
        // verifikasi password
        if(password_verify(trim($password),trim($user["Password_toko"]))){
            // buat Session
            session_start();
            $_SESSION["user"] = $user;
            // login sukses, alihkan ke halaman index pelanggan
            header("Location: admin/dashboard.php");
            
        }else{
            echo '<script>Useranme atau password salah</script>';
        }
    }else{
        echo '<script>Useranme atau password salah</script>';
    }
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

    <title>Login</title>
  </head>
  <body style="overflow:hidden">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 image-samping"></div>
            <div class="col-6">
                <div class="container-md">
                    <div class="row justify-content-center mt-5 mb-3 pt-5">
                        <div class="col-md-6">
                            <h1 class="text-center text-primary">Mikro UMKM</h1>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-5 pb-5">
                        <div class="col-md-4 d-flex justify-content-center">
                            <span class="login-label" style="text-align:center">Login</span>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form action="" method="POST" class="d-flex flex-column">
                                <input type="text" name="username" placeholder="username" class="underline-input mb-4">
                                <input type="password" name="password" placeholder="password" class="underline-input mb-4">
                                <input type="submit" name="login" value="Login" class="btn btn-primary w-75 mb-4" style="border-radius:20px;margin:0px auto;">
                                <p class="text-center">Belum Daftar? <span><a href="daftar.php">Daftar</a></span></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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