<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Validate.php");

$printer = new PrintHtml();
$validate= new Validate();
$validate -> validateAdmin();

$model=[];

$printer->printView("Admin", $model);
?>