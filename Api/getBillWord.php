<?php
include_once("../Models/Users.php");
include_once("../Models/Bill.php");
$data = json_decode( file_get_contents('php://input') );
header('Content-Type: application/json');
header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=2.doc");    
        echo "<html>";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
        echo "<body>";
        echo "<b>caca</b>";
        echo "</body>";
        echo "</html>";
$arrayData =(array) $data;
//print_r($arrayData);
//getWord();
die;