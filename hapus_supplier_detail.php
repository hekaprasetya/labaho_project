<?php
include "./include/config.php";
$id_supplier_detail = $_GET['id_supplier_detail'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from master_supplier_detail WHERE id_supplier_detail='$id_supplier_detail'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';

?>

