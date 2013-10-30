<?php

$id=$_GET['id'];
require("data_process/connect.php");
$sql = "SELECT * FROM JSON WHERE did = :id";
try {
    $st = $conn -> prepare ( $sql );
    $st -> bindValue( ":id", $id, PDO::PARAM_INT );
    $st -> execute();
    $rows = $st -> fetchAll();
    $ics = $rows[0]["content"];
    $filename = hash("sha256", $id);
	header('Content-type: text/calendar; charset=utf-8');
    header('Content-disposition: inline; filename=' . $filename . '.ics');
    echo $ics;
}
catch (PDOException $e){
    echo "Wrong, summary: " . $e;
}

?>