<?php
include "./include/config.php";
$id_gaji = $_GET['id_gaji'];
//print_r($_POST);die;
mysqli_query($conn, "DELETE from tbl_gaji WHERE id_gaji='$id_gaji'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';
