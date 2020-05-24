<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Validate.php");
include_once("../Models/Admin.php");
include_once("../Models/DBModel/DBCreation.php");

$validate= new Validate();
$validate -> validateAdmin();

// Metodo desarrollado en la clase Users
if(isset($_POST['eliminar'])){
    $elim=new Admin();
    if($elim -> eliminarUsuario($_POST['eliminar'])){
        echo "Exito";
    }
}

if(isset($_POST['modificar'])){

}
$printer = new PrintHtml();
$formulario = $printer->createView("Form",$printer);
$users = new Admin();
$values = $users -> getUsers(); 


$model=[
    "valores" => $values,
    "formulario" => $formulario
];

$printer->printView("Admin", $model);
?>