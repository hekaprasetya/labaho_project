<?php
include "./include/config.php";
$id_lpg_detail = $_GET['id_lpg_detail'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from tbl_lpg_detail WHERE id_lpg_detail='$id_lpg_detail'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';

?>

