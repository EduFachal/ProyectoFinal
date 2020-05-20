<?php 
include_once("../Models/PrintHtml.php");

$printer = new PrintHtml();

$model=[
];

$printer->printView("Admin", $model);
?>