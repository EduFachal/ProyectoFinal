<?php 
include_once("../Controllers/PrintHtml.php");

$printer = new PrintHtml();

$model=[
    "name1" => "Eduardo",
    "name2" => "<h1>safasf</h1>"
];

$printer->printView("Log", $model);
?>