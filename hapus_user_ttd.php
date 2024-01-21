<?php
include "./include/config.php";
$id_user = $_GET['id_user'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from tbl_user_upload WHERE id_user='$id_user'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';

?>

