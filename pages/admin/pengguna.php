<?php

require_once('../config.php');
require_once('../auth.php');


$get_pemesanan = $db->query("SELECT * FROM pemesanan");

$pemesanan = $get_pemesanan->fetchAll(PDO::FETCH_ASSOC);




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

    <title>Dashboard | Product List</title>
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
                    <div class="row mb-3">
                        <div class="col d-flex align-items-center">
                            <img src="../../assets/images/icons/dashboard/Box.png" alt="Product" class="icon me-3">
                            <a href="product_list.php"><span>Produk</span></a>
                            
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col d-flex align-items-center sidebar-active">
                            <img src="../../assets/images/icons/dashboard/User Male.png" alt="pengguna" class="icon me-3">
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
                    <h3 class="">List Pemesanan Pelanggan</h3>
                    
                </div>
                <div class="row">
                    <table class="product-list table table-striped table-light">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Produk</th>
                            <th scope="col">No hp</th>
                            <th scope="col">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                                $n = 1;
                                foreach($pemesanan as $pesan){

                                
                                    $get_pengguna = $db->prepare("SELECT * FROM pelanggan WHERE ID_pelanggan=:id_pelanggan");
                                    $pengguna = $get_pengguna->execute([
                                        ":id_pelanggan" => $pesan["ID_pelanggan"]
                                    ]);

                                    $pengguna = $get_pengguna->fetch(PDO::FETCH_ASSOC);

                                    $get_produk = $db->prepare("SELECT * FROM produk WHERE ID_produk=:id_produk");
                                    $produk = $get_produk->execute([
                                        ":id_produk" => $pesan["ID_produk"]
                                    ]);

                                    $produk = $get_produk->fetch(PDO::FETCH_ASSOC);
                                
                                
                            ?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td><?php echo $pengguna["Nama_pelanggan"]; ?></td>
                                <td><?php echo $pengguna["Email_pelanggan"]; ?></td>
                                <td><?php echo $pengguna["Alamat_pelanggan"]; ?></td>
                                <td><?php echo $produk["Nama_produk"]; ?></td>
                                <td><?php echo $pengguna["No_hp_pelanggan"]; ?></td>
                                <td><img src="../../assets/images/icons/product/Delete.png" alt="Delete" style="height:25px;width:25px"></td>
                            </tr>
                          <?php $n++;} ?>
                        </tbody>
                      </table>
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