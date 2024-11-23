<div class="row g-3 animate__animated animate__fadeInUp">
<?php
 require_once('conf/conf.php');
 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
 header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
 header("Cache-Control: no-store, no-cache, must-revalidate"); 
 header("Cache-Control: post-check=0, pre-check=0", false);
 header("Pragma: no-cache"); // HTTP/1.0
 date_default_timezone_set("Asia/Bangkok");
 $tanggal= mktime(date("m"),date("d"),date("Y"));
 $jam=date("H:i"); 
session_start(); // Mulai sesi untuk menyimpan posisi offset

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

// Tentukan jumlah data per halaman
$limit = 4;

// Hitung offset berdasarkan sesi
if (!isset($_SESSION['offset'])) {
    $_SESSION['offset'] = 0; // Mulai dari 0 jika sesi belum ada
} else {
    $_SESSION['offset'] += $limit; // Tambahkan offset untuk reload berikutnya
}

// Daftar kode `kd_poli` yang ingin ditampilkan
$kd_poli_list = "'U0001', 'U0002', 'U0003', 'U0004', 'U0005', 'U0006', 'U0007', 'U0008', 'U0011', 'U0012', 
                  'U0019', 'U0020', 'U0034', 'U0035', 'U0041', 'U0044', 'U0045', 'U0046', 'U0047'";

// Ambil total jumlah data yang sesuai dengan kriteria
$total_data_sql = "SELECT COUNT(*) as total FROM jadwal 
                   INNER JOIN dokter ON dokter.kd_dokter = jadwal.kd_dokter 
                   INNER JOIN poliklinik ON jadwal.kd_poli = poliklinik.kd_poli 
                   WHERE jadwal.hari_kerja = '$namahari'
                   AND poliklinik.kd_poli IN ($kd_poli_list)";
$total_data_result = bukaquery($total_data_sql);
$total_data = mysqli_fetch_assoc($total_data_result)['total'];

// Jika offset lebih besar atau sama dengan total data, reset ke awal
if ($_SESSION['offset'] >= $total_data) {
    $_SESSION['offset'] = 0;
}

// Ambil data dengan limit dan offset sesuai kriteria
$_sql = "SELECT dokter.nm_dokter, poliklinik.nm_poli, jadwal.jam_mulai, jadwal.jam_selesai 
         FROM jadwal 
         INNER JOIN dokter ON dokter.kd_dokter = jadwal.kd_dokter 
         INNER JOIN poliklinik ON jadwal.kd_poli = poliklinik.kd_poli 
         WHERE jadwal.hari_kerja = '$namahari' 
         AND poliklinik.kd_poli IN ($kd_poli_list)
         LIMIT $limit OFFSET {$_SESSION['offset']}";  

$hasil = bukaquery($_sql);
// Tampilkan data
while ($data = mysqli_fetch_array($hasil)) {
    echo "<div class='col-lg-3 col-md-6'>
                <div class='card text-center'>
                    <div class='card-body'>
                        <h6 class='card-title text-primary'>Jadwal Dokter Hari Ini</h6>
                        <h4> Dokter: <b>" . $data['nm_dokter'] . "</b>, <span class='badge bg-success'>Poli: <b>" . $data['nm_poli'] . "</b></span> , 
                        <span class='badge bg-danger'> Jam: <b>" . $data['jam_mulai'] . " - " . $data['jam_selesai'] . "</b></span></h4>
                    </div>
                </div>
            </div> ";
}
?>
</div>