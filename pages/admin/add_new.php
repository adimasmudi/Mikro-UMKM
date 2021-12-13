<?php

require_once('../config.php');
require_once('../auth.php');

// fetch kategori
$get_kategori = $db->query("SELECT * FROM kategori");
$data_kategori = $get_kategori->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST["publish"])){
    // filter data yang diinputkan
    $nama_produk = filter_input(INPUT_POST, 'nama_produk', FILTER_SANITIZE_STRING);

    $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);

    $harga_produk = filter_input(INPUT_POST, 'harga_produk', FILTER_VALIDATE_INT);

    $kategori = $_POST["kategori"];

    $id_toko = $_SESSION["user"]["ID_toko"];

    $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
    $tgl = $date->format('y-m-d H:i:s');

    // image upload
    if(array_key_exists('foto_produk',$_FILES)){
        if($_FILES['foto_produk']['name']){
            move_uploaded_file($_FILES['foto_produk']['tmp_name'], "../../Assets/images/produk/".$_FILES['foto_produk']['name']);
            $img="../../Assets/images/produk/".$_FILES['foto_produk']['name'];
        }
    }else{
        echo "<script>alert('Anda harus mengupload foto');</script>";
    }

    $sql = "INSERT INTO produk (ID_toko, Nama_produk, ID_kategori, Gambar_produk, Deskripsi_produk, Harga_produk, Tgl_tambah)
            VALUES (:id_toko, :nama_produk, :id_kategori, :gambar_produk, :deskripsi_produk, :harga_produk, :tgl_tambah)";

    $stmt = $db->prepare($sql);

    $kat = $db->prepare("SELECT * FROM kategori WHERE Nama_kategori=:nama_kategori");

    $the_kategori = $kat->execute([
        ":nama_kategori" => $kategori
    ]);

    $the_kategori = $kat->fetch(PDO::FETCH_ASSOC);

    echo $the_kategori["Nama_kategori"];


    

    $params = array(
        ":id_toko" => $id_toko,
        ":nama_produk" => $nama_produk,
        ":id_kategori" => $the_kategori["ID_kategori"],
        ":gambar_produk" => $img,
        ":deskripsi_produk" => $keterangan,
        ":harga_produk" => $harga_produk,
        ":tgl_tambah" => $tgl
    );

    $saved = $stmt->execute($params);

    if($saved) header('Location:dashboard.php');
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

    <link rel="stylesheet" href="../../assets/css/admin/style.css">

    <title>Add New</title>
  </head>
  <body>
    <div class="container-fluid">
        <div class="row navigation-dashboard">
            <div class="col-2">
                <h2 class="text-center text-light">Mikro UMKM</h2>
            </div>
            <div class="col-10 d-flex justify-content-end">
                <div class="d-flex flex-row align-items-center justify-content-evenly" style="width:200px;height:40px;line-height:40px;">
                    <div class="d-flex flex-row">
                        <img src="../../assets/images/dashboard/profile.png" alt="admin-profile" class="profile-photo me-3">
                        <span class="text-light">admin</span>
                    </div>
                    <img src="../../assets/images/icons/dashboard/Mail.png" alt="mail" class="icon">
                </div>
            </div>
        </div>
        <div class="sidebar row">
            <div class="col-2">
                <div class="container-fluid pt-5" style="padding:0">
                    <div class="row mb-3 ">
                        <div class="col d-flex align-items-center">
                            <img src="../../assets/images/icons/dashboard/Home.png" alt="Dashboard" class="icon me-3">
                            <a href="dashboard.php"><span>Dashboard</span></a>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex align-items-center sidebar-active">
                            <img src="../../assets/images/icons/dashboard/Box.png" alt="Product" class="icon me-3">
                            <a href="product_list.php"><span>Produk</span></a>
                        </div>
                    </div>
                    <div class="row inner-product">
                      <div class="col ms-3">
                          <img src="../../assets/images/icons/product/Add.png" alt="Add new" class="icon me-3">
                          <a href="add_new.php"><span>Add new</span></a>
                      </div>
                  </div>
                  <div class="row inner-product">
                      <div class="col ms-3">
                          <img src="../../assets/images/icons/product/Bulleted List.png" alt="Product list" class="icon me-3">
                          <a href="product_list.php"><span>Product list</span></a>
                      </div>
                  </div>
                  <div class="row inner-product">
                      <div class="col ms-3">
                          <img src="../../assets/images/icons/product/Category.png" alt="Kategori" class="icon me-3">
                          <a href="kategori.php"><span>Kategori</span></a>
                      </div>
                  </div>
                    <div class="row mb-3">
                        <div class="col d-flex align-items-center">
                            <img src="../../assets/images/icons/dashboard/User Male.png" alt="Pengguna" class="icon me-3">
                            <a href="pengguna.php"><span>Pengguna</span></a>
                        </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col d-flex align-items-center">
                          <img src="../../assets/images/icons/dashboard/Bookmark.png" alt="Feedback" class="icon me-3">
                          <a href="feedback.php"><span>Feedback</span></a>
                      </div>
                  </div>
                    <div class="row mb-3">
                        <div class="col d-flex align-items-center">
                            <img src="../../assets/images/icons/dashboard/Logout.png" alt="Logout" class="icon me-3">
                            <a href="../logout.php"><span>Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-10 pt-5 pb-5 pe-5 ps-5" style="margin-left:250px;height:100vh">
                <div class="row pe-5 ps-5 mt-5">
                    <h3 class="">Add new</h3>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row  pe-5 ps-5 mt-2">
                        <div class="card">
                            <h5 class="card-header">Nama Produk</h5>
                            <div class="card-body d-flex flex-row" style="height:10vh">
                                <input type="text" name="nama_produk" class="form-control me-4" placeholder="masukkan nama produk">
                                <input type="submit" name="publish" class="btn btn-primary" value="publish">
                            </div>
                        </div>
                    </div>
                    <div class="row ps-5 pe-5 mt-2">
                        <div class="col-8">
                            <div class="card">
                                <h5 class="card-header">Keterangan</h5>
                                <div class="card-body d-flex flex-row" style="height:35vh">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="keterangan" placeholder="keterangan" id="floatingTextarea2" style="height: 100px;width:30vw"></textarea>
                                        <label for="floatingTextarea2">Keterangan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <h5 class="card-header">harga Produk</h5>
                                        <div class="card-body d-flex flex-row" style="height:10vh">
                                            <input type="number" name="harga_produk" class="form-control me-4" placeholder="masukkan harga produk">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <h5 class="card-header">kategori</h5>
                                        <div class="card-body" style="height:20vh">
                                            <div class="dropdown mb-4">
                                                
                                                <select class="form-select" name="kategori" aria-label="Default select example">
                                                    <option selected disabled>--pilih kategori--</option>
                                                    <?php
                                                
                                                    
                                                    foreach($data_kategori as $kategori){
                                                    
                                                    ?>
                                                    <option value="<?php echo $kategori["Nama_kategori"]; ?>"><?php echo $kategori["Nama_kategori"]; ?></option>
                                                    
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div>
                                                <input type="file" name="foto_produk" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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