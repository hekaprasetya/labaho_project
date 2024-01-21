<?php
include "./include/config.php";
$id_pa_detail = $_GET['id_pa_detail'];
//print_r($_POST);die;
mysqli_query($conn,"DELETE from tbl_pa_detail WHERE id_pa_detail='$id_pa_detail'");

echo '<script language="javascript">
              window.history.go(-1);
     </script>';

?>

