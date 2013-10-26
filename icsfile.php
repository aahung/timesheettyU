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
    header('Content-disposition: attachment; filename=cityu_timetable.ics');
header('Content-type: text/plain');
    echo $ics;
}
catch (PDOException $e){
    echo "Wrong, summary: " . $e;
}

?>