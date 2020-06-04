<?php
/* Se recoge la info vinculada al id pasado por la url y se modifica la nueva contraseña y se borran los datos de la tabla temporal
 */
include_once("../Models/Admin.php");
$userAdm= new Admin();
$data = $userAdm -> getUserStrNewPass($_GET["id"]);

if($userAdm->updateUserStrNewPass($data["idUser"],$data["pass"])){
    header("Location: ../Controllers/Index.php");
}


