<?php
include "./include/config.php";
$id_karyawan = $_GET['id_karyawan'];
//print_r($_POST);die;
mysqli_query($conn, "DELETE from master_karyawan WHERE id_karyawan='$id_karyawan'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';
