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
?>
<?php
session_start(); // Memulai session

// Jumlah data per halaman
$data_per_halaman = 10;

// Cek apakah session `current_page` ada, jika tidak set ke 0
if (!isset($_SESSION['current_page'])) {
    $_SESSION['current_page'] = 0;
}

// Ambil jumlah total data dari database
$_sql_count = "SELECT COUNT(*) as total FROM (
    SELECT a.kode_kelas_aplicare
    FROM aplicare_ketersediaan_kamar a
    JOIN bangsal b ON a.kd_bangsal = b.kd_bangsal
    WHERE b.status = '1'
    GROUP BY a.kode_kelas_aplicare, a.kd_bangsal, b.nm_bangsal
) as total_data";
$result_count = bukaquery($_sql_count);
$data_count = mysqli_fetch_assoc($result_count);
$total_data = $data_count['total'];

// Hitung halaman maksimal
$total_halaman = ceil($total_data / $data_per_halaman);

// Ambil data sesuai halaman saat ini
$offset = $_SESSION['current_page'] * $data_per_halaman;

$_sql = "SELECT a.kode_kelas_aplicare, 
                CASE 
                    WHEN a.kode_kelas_aplicare = 'HCU' THEN 'HCU'
                    WHEN a.kode_kelas_aplicare = 'KL1' THEN 'KELAS 1'
                    WHEN a.kode_kelas_aplicare = 'KL2' THEN 'KELAS 2'
                    WHEN a.kode_kelas_aplicare = 'KL3' THEN 'KELAS 3'
                    WHEN a.kode_kelas_aplicare = 'ISO' THEN 'ISOLASI'
                    WHEN a.kode_kelas_aplicare = 'ICU' THEN 'ICU'
                    WHEN a.kode_kelas_aplicare = 'NIC' THEN 'NICU'
                    WHEN a.kode_kelas_aplicare = 'UTM' THEN 'PERINA'
                    WHEN a.kode_kelas_aplicare = 'SAL' THEN 'RUANG BERSALIN'
                    ELSE a.kode_kelas_aplicare
                END AS nama_kelas,
                a.kd_bangsal, 
                b.nm_bangsal, 
                SUM(a.kapasitas) AS total_kapasitas, 
                SUM(a.tersedia) AS total_tersedia, 
                SUM(a.tersediapria) AS total_tersediapria, 
                SUM(a.tersediawanita) AS total_tersediawanita, 
                SUM(a.tersediapriawanita) AS total_tersediapriawanita,
                (SUM(a.kapasitas) - SUM(a.tersedia)) AS bed_kosong
         FROM aplicare_ketersediaan_kamar a
         JOIN bangsal b ON a.kd_bangsal = b.kd_bangsal
         WHERE b.status = '1'
         GROUP BY a.kode_kelas_aplicare, a.kd_bangsal, b.nm_bangsal, nama_kelas
         ORDER BY FIELD(a.kode_kelas_aplicare, 'VIP', 'KL1', 'KL2', 'KL3', 'ISO', 'HCU', 'ICU', 'NIC', 'UTM', 'SAL'), nama_kelas
         LIMIT $data_per_halaman OFFSET $offset";

$hasil = bukaquery($_sql);

// Tampilkan data
echo "
<table class='table table-striped table-hover animate__animated animate__zoomIn'>
     <thead>
         <tr>
              <td width='40%'><div align='left'><b>NAMA KAMAR</b></font></div></td>
              <td width='20%'><div align='center'><b>KELAS</b></font></div></td>
              <td width='20%'><div align='center'><b>JUMLAH</b></font></div></td>
              <td width='20%'><div align='center'><b>TERISI</b></font></div></td>
              <td width='20%'><div align='center'><b>KOSONG</b></font></div></td>
         </tr>
           </thead>
                                <tbody>";

while ($data = mysqli_fetch_array($hasil)) {
    echo "<tr >
            <td align='left'><b>".$data['nm_bangsal']."</b></td>
            <td align='left'><b>".$data['nama_kelas']."</b></td>
            <td align='center'>
                 <font color='red' face='Tahoma'><b>".$data['total_kapasitas']."</b></font>
            </td>
            <td align='center'>
                 <font color='#DDDD00' face='Tahoma'><b>".$data['bed_kosong']."</b></font>
            </td>
            <td align='center'>
                 <font color='green' face='Tahoma'><b>".$data['total_tersedia']."</b></font>
            </td>
          </tr>";
}

echo "</tbody></table>
           ";

// Update session halaman berikutnya
$_SESSION['current_page'] = ($_SESSION['current_page'] + 1) % $total_halaman;
?>

