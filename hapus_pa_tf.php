<?php
include "./include/config.php";
$id_tf = $_GET['id_tf'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from tbl_pa_tf WHERE id_tf='$id_tf'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';

?>

