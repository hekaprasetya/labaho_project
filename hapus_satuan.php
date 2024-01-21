<?php
include "./include/config.php";
$id_satuan = $_GET['id_satuan'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from master_satuan WHERE id_satuan='$id_satuan'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';

?>

