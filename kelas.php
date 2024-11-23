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
<div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Kelas Kamar</th>
                                        <th>Jumlah Bed</th>
                                        <th>Bed Terisi</th>
                                        <th>Bed Kosong</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php  
                  $_sql="Select kelas from kamar where statusdata='1' group by kelas" ;  
                  $hasil=bukaquery($_sql);

                  while ($data = mysqli_fetch_array ($hasil)){
                                   echo" <tr>
                                        <td>".$data['kelas']."</td>
                                        <td>";
                               $data2=mysqli_fetch_array(bukaquery("select count(kelas) from kamar where statusdata='1' and kelas='".$data['kelas']."'"));
                               echo $data2[0];
                        echo "</td>
                                        <td>";
                             $data2=mysqli_fetch_array(bukaquery("select count(kelas) from kamar where statusdata='1' and kelas='".$data['kelas']."' and status='ISI'"));
                             echo $data2[0];
                        echo "</td>
                                        <td><span class='badge bg-success'>";
                             $data2=mysqli_fetch_array(bukaquery("select count(kelas) from kamar where statusdata='1' and kelas='".$data['kelas']."' and status='KOSONG'"));
                             echo $data2[0];
                        echo "</span></td>
                                    </tr>";
                  } ?>
                                </tbody>
                            </table>

</div>