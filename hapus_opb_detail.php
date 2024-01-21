<?php
include "./include/config.php";
$id_opb_detail = $_GET['id_opb_detail'];
//print_r($_POST);die;
mysqli_query($conn, "DELETE from tbl_opb_detail WHERE id_opb_detail='$id_opb_detail'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';
