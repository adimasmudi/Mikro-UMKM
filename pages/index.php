<?php

require_once('config.php');

$produk = $db->query("SELECT * FROM produk");
$product_arr = $produk->fetchAll(PDO::FETCH_ASSOC);


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

    <title>Halaman Utama</title>
  </head>
  <body>
    <header class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light pb-5">
            <div class="container-md">
              <a class="navbar-brand fw-bold" href="#">Mikro UMKM</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav" style="margin-left:70%">
                  <li class="nav-item">
                    <a class="nav-link nav-link__active" aria-current="page" href="index.html">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#daftar">Daftar</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#produk">Produk</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#tentang">Tentang</a>
                  </li>
                </ul>
              </div>
            </div>
        </nav>
        <section class="container-md jumbotron pt-5 mt-5">
            <h3 class="pt-2 pb-3">Halo, Selamat Datang</h3>
            <h1 class="pb-3">Usaha Mikro Kecil dan Menengah</h1>
            <p class="pb-3">Usaha perdagangan yang dikelola oleh badan usaha atau perorangan yang merujuk pada usaha ekonomi produktif</p>
            <div>
                <a class="btn bttn-primary" id="daftar" href="daftar.php">Daftar</a>
                <a class="btn bttn-secondary" href="login.php">login</a>
            </div>
        </section>
    </header>

    <section class="container-fluid product-photo pt-5">
        <div class="container-md">
            <div class="row">
                <div class="col">
                    <h2 class="text-center" id="produk">Produk Umum</h2>
                    <p class="text-center">Beberapa produk UMKM</p>
                </div>
            </div>
            <div class="row justify-content-evenly">
                <?php
                    foreach($product_arr as $product){
                ?>
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img
                         src="
                         <?php
                            $old_path = $product["Gambar_produk"];
                            $new_path = array_slice(explode("/",$old_path),1,sizeof(explode("/",$old_path))-1);
                            echo join("/",$new_path);
                            
                         ?>
                         " 
                         alt="<?php echo $product["Nama_produk"]; ?>" class="img-thumbnail" style="height:240px;width:310px;"
                         >
                        <a href="detail_produk.php?<?php echo $product["ID_produk"]; ?>" style="text-decoration:none;color : black;">
                            <h4 class="text-center"><?php echo $product["Nama_produk"]; ?></h4>
                        </a>
                        <span class="text-center">
                            <?php
                                $get_kategori = $db->query("SELECT * FROM kategori WHERE ID_kategori=".$product["ID_kategori"]);
                                $kategori = $get_kategori->fetch(PDO::FETCH_ASSOC);

                                echo $kategori["Nama_kategori"];
                            
                            
                            ?>
                        </span>
                        <span class="text-center">Harga Rp. <?php echo number_format($product["Harga_produk"]); ?></span>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="row mb-5">
                <div class="col d-flex justify-content-center">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn bttn-primary mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal" style="height:40px;width:180px">
                        Lihat semua
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <input type="text" class="form-control" placeholder="kategori" name="kategori">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <input type="submit" class="btn btn-primary" name="simpan" value="simpan">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       

    </section>

    <section class="container-md tentang mt-5">
        <h2 class="text-center" id="tentang">Tentang</h2>
        <p class="text-center">Website ini dibuat untuk memenuhi tugas project akhir sistem informasi</p>

        <div class="row ms-auto justify-content-center mb-5">
            <div class="col-7">
                <div class="row d-flex flex-row justify-content-evenly">
                    <div class="col-6 left">
                        <h1 class="mt-4">Usaha Mikro Kecil dan Menengah</h1>
                        <p class="mt-3">umkm adalah usaha perdagangan yang dikelola oleh badan usaha atau perorangan yang merujuk pada usaha ekonomi produktif sesuai dengan kriteria yang ditetapkan oleh Undang-Undang Nomor 20 Tahun 2008</p>
                    </div>
                    <div class="col-2 right">
                        <div class="circle-blue">
                            <span class="UMKM">UMKM</span>
                        </div>
                        <div class="tail"></div>
                        <div class="circle">
                            <span class="SI">Sistem</span><br>
                            <span class="SI">Informasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container-md">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="ms-4 mt-4">Mikro Umkm</h2>
                </div>
                <div class="col-md-4">
                    <h6 class="ms-4">Contact Us</h6>
                    <ul>
                        <li><img src="../assets/images/homepage/Location.png" alt="location"> Jalan Mawar Baru No.14 Surabaya</li>
                        <li><img src="../assets/images/homepage/Phone.png" alt="phone"> 0812345678</li>
                        <li><img src="../assets/images/homepage/Email Open.png" alt="email"> Mikroumkm@gmail.com</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="ms-4">Universitas Trunojoyo Madura</h6>
                    <ul class="icons">
                        <li><img src="../assets/images/homepage/Facebook.png" alt="fb"></li>
                        <li><img src="../assets/images/homepage/Twitter.png" alt="twitter"></li>
                        <li><img src="../assets/images/homepage/Instagram.png" alt="instagram"></li>
                        <li><img src="../assets/images/homepage/Google Plus.png" alt="Google Plus"></li>
                        <li><img src="../assets/images/homepage/YouTube.png" alt="Youtube"></li>
                    </ul>
                    <span class="ms-4">Hak cipta 2021 - Mikro UMKM</span>
                </div>
            </div>
        </div>
    </footer>



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