<?php

require_once('config.php');

$n=20;
function getName($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
}
  


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

$id_produk = explode('-',explode('?',$link)[1])[0];
$id_toko = explode('-',explode('?',$link)[1])[1];
$produk = $db->query("SELECT * FROM produk WHERE ID_produk=".$id_produk)->fetch(PDO::FETCH_ASSOC);

$id_pesanan = getName($n);

$id_pelanggan = getName($n);


if(isset($_POST["checkout"])){
    // filter data yang diinputkan
    $nama_pelanggan = filter_input(INPUT_POST, 'nama_pelanggan', FILTER_SANITIZE_STRING);

    $alamat_pelanggan = filter_input(INPUT_POST, 'alamat_pelanggan', FILTER_SANITIZE_STRING);

    $email_pelanggan = filter_input(INPUT_POST, 'email_pelanggan', FILTER_VALIDATE_EMAIL);

    $no_hp_pelanggan = filter_input(INPUT_POST, 'no_hp_pelanggan', FILTER_SANITIZE_STRING);

    $nama_produk = filter_input(INPUT_POST, 'nama_produk', FILTER_SANITIZE_STRING);


    

    $feedback_data = filter_input(INPUT_POST, 'feedback', FILTER_SANITIZE_STRING);

    


    $pelanggan = $db->prepare("INSERT INTO pelanggan (ID_pelanggan, Nama_pelanggan, Alamat_pelanggan, Email_pelanggan, No_hp_pelanggan) VALUES (:id_pelanggan, :nama_pelanggan, :alamat_pelanggan, :email_pelanggan, :no_hp_pelanggan)");

    $save_pelanggan = $pelanggan->execute([
        ":id_pelanggan" => $id_pelanggan,
        ":nama_pelanggan" => $nama_pelanggan,
        ":alamat_pelanggan" => $alamat_pelanggan,
        ":email_pelanggan" => $email_pelanggan,
        ":no_hp_pelanggan" => $no_hp_pelanggan
    ]);

    

    $pemesanan = $db->prepare("INSERT INTO pemesanan (ID_pesanan, ID_pelanggan, Total_harga, ID_toko, ID_produk) VALUES (:id_pesanan,:id_pelanggan, :total_harga, :id_toko, :id_produk)");

    $save_pemesanan = $pemesanan->execute([
        ":id_pesanan" => $id_pesanan,
        ":id_pelanggan" => $id_pelanggan,
        ":total_harga" => $produk["Harga_produk"],
        ":id_toko" => $id_toko,
        ":id_produk" => $id_produk
    ]);


    $feedback = $db->prepare("INSERT INTO feedback (ID_pelanggan, ID_produk, feedback) VALUES (:id_pelanggan, :id_produk, :feedback)");

    $save_feedback = $feedback->execute([
        ":id_pelanggan" => $id_pelanggan,
        ":id_produk" => $id_produk,
        ":feedback" => $feedback_data
    ]);

    if($save_feedback AND $save_pelanggan AND $save_pemesanan) header('Location:index.php');

    




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

    <title>Halaman Utama</title>
  </head>
  <body>

    <br>

    <section class="container-md detail-produk">
        <div class="row">
            <div class="col">
                <h2 class="text-center fw-bold">Pembayaran</h2>
                <p class="text-center">Lengkapi data diri anda</p>
            </div>
        </div>

        <br>

        <div class="card center" style="max-width: 720px;">
            <div class="card-header blue-card">
                Masukkan Data Diri
            </div>
            <form action="" method="POST">
                <div class="row">
                    <div class="col">
                        <div class="card-body">
                            <label for="inputNama" class="form-label">Nama</label>
                            <input type="text" id="inputNama" name="nama_pelanggan" class="form-control">
                            <br>
                            <label for="inputAlamat" class="form-label">Alamat</label>
                            <input type="text" id="inputAlamat" name="alamat_pelanggan" class="form-control">
                            <br>
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" id="inputEmail" name="email_pelanggan" class="form-control">
                            <br>
                            <label for="inputTelp" class="form-label">No. Hp</label>
                            <input type="text" id="inputTelp" name="no_hp_pelanggan" class="form-control">
                            <br>
                            <label for="inputProduk" class="form-label">Nama Produk</label>
                            <input type="text" id="inputProduk" name="nama_produk" class="form-control" value="<?php echo $produk["Nama_produk"]; ?>" disabled>
                            <br>
                            <label for="inputHarga" class="form-label">Harga</label>
                            <input type="text" id="inputHarga" name="harga_produk" class="form-control" value="<?php echo $produk["Harga_produk"]; ?>" disabled>
                            <br>
                            <label for="feedback">Feedback</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
                <div class="row justify-content-end m3-5 mb-5">
                    <div class="col-4">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn bttn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="height:40px;width:180px">
                            checkout
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <span>Apakah anda yakin ingin checkout? data anda akan kami simpan dan kami akan menghubungi anda untuk pengiriman barangnya</span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <input type="submit" class="btn btn-primary" name="checkout" value="yakin">
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>

        <br>

        <div class="card center" style="max-width: 720px;">
            <div class="card-header red-card">
                Pembayaran
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col">
                        <div class="card center text-center">
                            <div class="card-header fw-bold">
                                Silahkan Melakukan Pembayaran Transfer ke Rekening Berikut
                            </div>
                            <div class="card-body">
                                <p class="card-text">No Rekening : 1234-01-021122-21-7</p>
                                <p class="card-text">Bank BCA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                </div>
            </div>
        </div>
    </section>

    <br><br>

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
