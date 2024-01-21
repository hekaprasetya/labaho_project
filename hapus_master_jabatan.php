<?php
include "./include/config.php";
$id_jabatan = $_GET['id_jabatan'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from master_jabatan WHERE id_jabatan='$id_jabatan'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';
