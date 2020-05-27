<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Validate.php");
include_once("../Models/Admin.php");


$validate= new Validate();
$validate -> validateAdmin();

// Comprobacion para eliminar un usuario
if(isset($_POST['eliminar'])){
    $delete=new Admin();
    if($delete -> eliminarUsuario($_POST['eliminar'])){
        echo "Exito";
    }
}

// Funcion para modificar
$printer = new PrintHtml();


$users = new Admin();
$values = $users -> getUsers();


$model=[
    "valores" => $values
];

$printer->printView("Admin", $model);
?>