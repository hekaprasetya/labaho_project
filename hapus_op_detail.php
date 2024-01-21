<?php
include "./include/config.php";
$id_op_detail = $_GET['id_op_detail'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from tbl_op_detail WHERE id_op_detail='$id_op_detail'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';

?>

