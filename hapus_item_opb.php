<?php

$i = $_GET['id'];
//echo $i;
@session_start();
$tableDet = $_SESSION["tableDet"];

if ($tableDet == TRUE) {
    $tableDet[$i]["mode_item"] = "D";
    $_SESSION["tableDet"] = $tableDet;
}

header("Location: ./admin.php?page=opb&act=add");
die();
?>
