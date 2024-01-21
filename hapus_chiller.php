<?php
include "./include/config.php";
$id_chiller = $_GET['id_chiller'];
//print_r($_POST);die;
mysqli_query($conn, "DELETE from utility_chiller WHERE id_chiller='$id_chiller'");

echo '<script language="javascript">
              window.history.go(-1);
                                              </script>';
