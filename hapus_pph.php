<?php
include "./include/config.php";
$id_pph = $_GET['id_pph'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from master_pph WHERE id_pph='$id_pph'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';

?>

