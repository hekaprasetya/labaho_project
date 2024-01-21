<?php
include "./include/config.php";
$id_dp = $_GET['id_dp'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from tbl_pa_dp WHERE id_dp='$id_dp'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';

?>

