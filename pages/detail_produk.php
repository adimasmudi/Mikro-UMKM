<?php

require_once('config.php');

// Program to display URL of current page.
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
$link = "https";
else $link = "http";

// Here append the common URL characters.
$link .= "://";

// Append the host(domain name, ip) to the URL.
$link .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$link .= $_SERVER['REQUEST_URI'];

$id_produk = explode('?',$link)[1];

$produk = $db->query("SELECT * FROM produk WHERE ID_produk=".$id_produk)->fetch(PDO::FETCH_ASSOC);



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

    <style>
        .hidden{
            display:none;
        }
    </style>

    <title>Detail Produk</title>
  </head>
  <body>

    <br>

    <section class="container-md detail-produk">
        <div class="row">
            <div class="col">
                <h2 class="text-center fw-bold">Detail Produk</h2>
                <p class="text-center">Detail produk dari produk Umkm Mikro</p>
            </div>
        </div>

        <br>

        <div class="card mb-3 center" style="max-width: 720px;">
            <div class="row g-0">
              <div class="col-md-6">
                <img 
                    src="
                        <?php
                        $old_path = $produk["Gambar_produk"];
                        $new_path = array_slice(explode("/",$old_path),1,sizeof(explode("/",$old_path))-1);
                        echo join("/",$new_path);
                        
                        ?>
                    " 
                    alt="<?php echo $produk["Nama_produk"]; ?>" class="img-fluid rounded-start">
              </div>
              <div class="col-md-6">
                <div class="card-body">
                    <div class="row justify-content-start align-items-center">
                        <div class="col-sm-2">
                            <div class="icons">
                                <img src="..\assets\images\icons\detail\Shop.png">
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="card-title fw-bold">
                                <?php
                                    $toko = $db->query("SELECT * FROM toko WHERE ID_toko=".$produk["ID_toko"])->fetch(PDO::FETCH_ASSOC);
                                    echo $toko["Nama_toko"];
                                ?>
                            </h5>
                        </div>
                    </div>
                    <hr class="my-20">
                    <h5 class="card-title fw-bold"><?php echo $produk["Nama_produk"]; ?></h5>
                    <p class="card-text">Total Rp. <?php echo number_format($produk["Harga_produk"]); ?></p>
                    <a href="pembayaran.php?<?php echo $produk["ID_produk"]; ?>-<?php echo $produk["ID_toko"]; ?>" class="btn bttn-primary btn-sm">
                        <div class="row justify-content-start align-items-center">
                            <div class="col-sm-1">
                                <div class="icons">
                                    <img src="..\assets\images\icons\detail\Shopping Cart With Money.png">
                                </div>
                            </div>
                            <div class="col">
                                Pesan 
                            </div>
                        </div>
                    </a>
                    <button type="button" class="desc-toggle btn bttn-red btn-sm">
                        <div class="row justify-content-start align-items-center">
                            <div class="col-sm-1">
                                <div class="icons">
                                    <img src="..\assets\images\icons\detail\Document.png">
                                </div>
                            </div>
                            <div class="col">
                                Deskripsi Produk
                            </div>
                        </div>
                    </button>
                </div>
              </div>
            </div>
        </div>

        <br>

        <div class="desc-box card center red-card hidden" style="max-width: 720px;">
            <div class="card-body">
              <h5 class="card-title">Deskripsi Produk</h5>
              <hr class="my-20">
              <p class="card-text"><?php echo $produk["Deskripsi_produk"]; ?></p>
            </div>
        </div>

    </section>

    <br><br>
    <!-- Optional JavaScript; choose one of the two! -->

    <script>
        const descBox = document.querySelector(".desc-box");
        const descToggle = document.querySelector(".desc-toggle");

        descToggle.addEventListener("click",function(){
            descBox.classList.toggle("hidden");
        });
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
