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
<html>
<head>
  <title><?php echo $setting["nama_instansi"];?></title>
  <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/portfolio-item.css" rel="stylesheet">

    <!-- Owl carousel -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="assets/marquee.css" />
    <link rel="stylesheet" href="assets/example.css" />

    
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">&nbsp;<?php echo $setting["nama_instansi"];?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="pull-right"> 
          <a href="" class="navbar-brand">
          <?php
                              $a_hari   = array(1=>"Senin","Selasa","Rabu","Kamis","Jumat", "Sabtu","Minggu");
                              $hari     = $a_hari[date("N")];
                              $tanggal  = date ("j");
                              $a_bulan  = array(1=>"Januari","Februari","Maret", "April", "Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember");
                              $bulan    = $a_bulan[date("n")];
                              $tahun    = date("Y"); 
                              echo $hari . ", " . $tanggal ." ". $bulan ." ". $tahun;
                            ?>
          </a>
    
                        <a href="" class="navbar-brand" id="jam"></a>
        </div>
      </div>
  </nav>

  <div class="wrapper">

</br>

    <section id="content">
      <div class="container-fluid">
          <div class="row">
              
            <div class="col-lg-6" id="data">
             </div>
         <div class="col-lg-6">
    <video id="myVideo" width="100%" height="100%" controls autoplay muted>
        <source src="jkn.mp4" type="video/mp4">
    </video>
</div>
          
          </div>
      </div>
    

  <footer class="footer">
      <div class="container-fluid">
          <div class="simple-marquee-container">
            <div class="marquee-sibling">
              Tarif Kamar Umum
            </div>
            <marquee class="marquee" scrollamount="4">
                  <?php 
                    $sql ="SELECT kelas, trf_kamar FROM kamar WHERE statusdata='1' GROUP BY kelas";
                    $hasil=bukaquery($sql);
                    while ($data = mysqli_fetch_array ($hasil)){
                  ?>
                   <span class="marquee-content-items">| <?= $data['kelas'];?> Rp <?= number_format($data['trf_kamar'], 0, ".",",");?></span>
                  <?php } ?>
            </marquee>
          </div>
      </div>
    </footer>
      <footer class="footer">
      <div class="container-fluid">
          <?php  
$hari = getOne("select DAYNAME(current_date())");
$namahari = "";

switch($hari) {
    case "Sunday": $namahari = "AKHAD"; break;
    case "Monday": $namahari = "SENIN"; break;
    case "Tuesday": $namahari = "SELASA"; break;
    case "Wednesday": $namahari = "RABU"; break;
    case "Thursday": $namahari = "KAMIS"; break;
    case "Friday": $namahari = "JUMAT"; break;
    case "Saturday": $namahari = "SABTU"; break;
}

$_sql = "SELECT dokter.nm_dokter, poliklinik.nm_poli, jadwal.jam_mulai, jadwal.jam_selesai 
         FROM jadwal 
         INNER JOIN dokter ON dokter.kd_dokter = jadwal.kd_dokter 
         INNER JOIN poliklinik ON jadwal.kd_poli = poliklinik.kd_poli 
         WHERE jadwal.hari_kerja = '$namahari'";  

$hasil = bukaquery($_sql);

echo '<div class="simple-marquee-container">';
echo '<div class="marquee-sibling">Jadwal Dokter Hari Ini</div>';
echo '<marquee class="marquee" scrollamount="4">';

while ($data = mysqli_fetch_array($hasil)) {
    echo "Dokter: <b>" . $data['nm_dokter'] . "</b>, Poli: <b>" . $data['nm_poli'] . "</b>, Jam: <b>" . $data['jam_mulai'] . " - " . $data['jam_selesai'] . "</b> | ";
}

echo '</marquee>';
echo '</div>';
?>

      </div>
    </footer>
      </div>
    </section>

  
<script type="text/javascript" src="conf/validator.js"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<!-- Footer -->

<!-- Bootstrap core JavaScript -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.js"></script> 
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
