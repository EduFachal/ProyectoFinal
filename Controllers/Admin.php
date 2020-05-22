<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Validate.php");
include_once("../Models/Users.php");

$printer = new PrintHtml();
$validate= new Validate();
$validate -> validateAdmin();

// Metodo desarrollado en la clase Users
if(isset($_POST['eliminar'])){
    $elim=new Users();
    if($elim -> eliminarUsuario($_POST['eliminar'])){
        echo "Exito";
    }
}

$users = new Users();
$values = $users -> getUsers();

$model=[
    "valores" => $values
];

$printer->printView("Admin", $model);
?>