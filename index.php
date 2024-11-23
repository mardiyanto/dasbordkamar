<?php
 //fitur update kamar aplicare ini adalah penyempurnaan dari kontribusi Mas Tirta dari RSUK Ciracas Jakarta Timur
 session_start();
 require_once('conf/conf.php');
 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
 header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
 header("Cache-Control: no-store, no-cache, must-revalidate"); 
 header("Cache-Control: post-check=0, pre-check=0", false);
 header("Pragma: no-cache"); // HTTP/1.0
 date_default_timezone_set("Asia/Bangkok");
 $tanggal= mktime(date("m"),date("d"),date("Y"));
 $jam=date("H:i");
 $setting=  mysqli_fetch_array(bukaquery("select setting.nama_instansi,setting.alamat_instansi,setting.kabupaten,setting.propinsi,setting.kontak,setting.email,setting.logo from setting"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard with Animation</title>
    <!-- Bootstrap 5 CSS -->
    <link href="sys/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="sys/animate.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #28a745; /* Warna hijau */
        }
        .navbar .navbar-brand, .navbar .nav-link {
            color: white;
        }
        .navbar .navbar-brand:hover, .navbar .nav-link:hover {
            color: #f8f9fa;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg animate__animated animate__fadeInDown">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fas fa-hospital me-2"></i> <?php echo $setting["nama_instansi"];?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"> <?php
                              $a_hari   = array(1=>"Senin","Selasa","Rabu","Kamis","Jumat", "Sabtu","Minggu");
                              $hari     = $a_hari[date("N")];
                              $tanggal  = date ("j");
                              $a_bulan  = array(1=>"Januari","Februari","Maret", "April", "Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember");
                              $bulan    = $a_bulan[date("n")];
                              $tahun    = date("Y"); 
                              echo $hari . ", " . $tanggal ." ". $bulan ." ". $tahun;
                            ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="jam"></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container-fluid mt-4">
        <!-- Header -->
        <!-- <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeInLeft">
            <h1 class="h4"></h1>
            <div>
                <input type="text" class="form-control d-inline-block w-auto" placeholder="Search for...">
                <button class="btn btn-primary">Search</button>
            </div>
        </div> -->

        <!-- Summary Cards -->
        <div class="row g-3 animate__animated animate__fadeInUp">
            <div class="col-lg-4 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
            
                        <h6 class="card-title text-primary">Earnings (Monthly)</h6>
                        <h4>$40,000</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title text-success">Earnings (Annual)</h6>
                        <h4>$215,000</h4>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title text-warning">Pending Requests</h6>
                        <h4>18</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-3 mt-4">
           <div class="col-lg-4 animate__animated animate__zoomIn">
                <div class="card">
                    <div class="card-header">Informasi Kamar Inap</div>
                    <div class="card-body">
                    <div  id="data">
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 animate__animated animate__zoomIn">
                <div class="card">
                    <div class="card-header">JKN</div>
                    <div class="card-body">
                        <!-- Placeholder for Pie Chart -->
                        <video id="myVideo" width="100%" height="100%" controls autoplay muted>
                            <source src="jkn.mp4" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 animate__animated animate__zoomIn">
                <div class="card">
                    <div class="card-header">Revenue Sources</div>
                    <div class="card-body">
                        <!-- Placeholder for Pie Chart -->
                        <div  id="kelas">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="row g-3 mt-4 animate__animated animate__fadeInUp">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Recent Transactions</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2024-11-01</td>
                                        <td>Payment from Client A</td>
                                        <td>$2,000</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>2024-11-05</td>
                                        <td>Refund to Client B</td>
                                        <td>-$500</td>
                                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>2024-11-10</td>
                                        <td>Payment from Client C</td>
                                        <td>$3,500</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>2024-11-15</td>
                                        <td>Purchase of Office Supplies</td>
                                        <td>-$1,000</td>
                                        <td><span class="badge bg-danger">Failed</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="sys/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script> 
    <script type="text/javascript"> 
        var auto_refresh = setInterval( 
            function() { 
                $('#data').load('data_bed.php').fadeIn("fast"); 
            }, 9000
        ); 
    </script>
   <script>
    // Mendapatkan elemen video
    var video = document.getElementById("myVideo");

    // Atur volume video ke 20% (0.2)
    video.volume = 0.2;

    // Mendeteksi ketika video selesai diputar
    video.addEventListener("ended", function() {
        // Mengatur ulang waktu video ke awal
        video.currentTime = 0;
        // Memulai pemutaran video kembali
        video.play();
    });
</script>
<script type="text/javascript">
       window.onload = function() { jam(); }

       function jam() {
        var e = document.getElementById('jam'),
        d = new Date(), h, m, s;
        h = d.getHours();
        m = set(d.getMinutes());
        s = set(d.getSeconds());

        e.innerHTML = h +':'+ m +':'+ s;

        setTimeout('jam()', 1000);
       }

       function set(e) {
        e = e < 10 ? '0'+ e : e;
        return e;
      }
    </script>

</body>
</html>
