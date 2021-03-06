<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");
include_once("../Models/Admin.php");
include_once("../Models/SendEmail.php");
$validate = new Validate();
$menuPrint = new Menu();
$mail = new EMail();

// Funcion para comprobar si hay usuario logeado y pintar los botones en el menu de las acciones a realizar -> Models/Validate.php
$dataControllerAlta = $menuPrint-> selection("home");
if($validate -> checkConnect()){
    $buttonProfile= $menuPrint -> getMenu(1);
    $dataControllerAlta["botonMenu"] = $buttonProfile;
    
}else{
    $buttonProfile= $menuPrint -> getMenu(0);
    $dataControllerAlta["botonMenu"] = $buttonProfile;
}

/* Metodo para registrar un usuario en Alta, instanciando un objeto de Users para luego 
    llamar a un metodo suyo que es 'registrarUsuario', el usuario es unico, si se repite vuelve a mostrar el
    formulario, en caso de creacion correcta se ira al Index*/

if(isset($_POST['registrar'])){
    $register=new Admin();
    $arrayDataClient= array(
        "user" => $_POST['usuario'],
        "pass" => $_POST['clave'],
        "nombre" => $_POST['nombre'],
        "apellidos" => $_POST['apellidos'],
        "email" => $_POST['email'],
        "direccion" => $_POST['direccion'],
        "codigoPostal" => $_POST['codigoPostal'],
        "localidad" => $_POST['localidad'],
        "provincia" => $_POST['provincia'],
        "telefono" => $_POST['telefono'],
        "nacimiento" => $_POST['nacimiento']
    );
    $validateUser = $register->getUserExist($arrayDataClient["user"]);
    if($validateUser){
        $dataControllerAlta= [
            "nombre" => $_POST['nombre'],
            "apellidos" => $_POST['apellidos'],
            "email" => $_POST['email'],
            "direccion" => $_POST['direccion'],
            "codigoPostal" => $_POST['codigoPostal'],
            "localidad" => $_POST['localidad'],
            "provincia" => $_POST['provincia'],
            "telefono" => $_POST['telefono'],
            "nacimiento" => $_POST['nacimiento']
        ];
        echo'<script type="text/javascript">
            window.alert("Usuario ya existente, cambie el usuario");
            window.location.href="../Controllers/Alta.php";
            </script>';
        header("Location: ../Controllers/Alta.php");
    }else{
        $register -> aniadirCliente($arrayDataClient);  
        $mail-> sendMailDefault();
        echo'<script type="text/javascript">
            alert("Bienvenido a nuestra tienda");
            window.location.href="../Controllers/Alta.php";
            </script>';
        header("Location: ../Controllers/Index.php");
    }
    
}else{
    $dataControllerAlta= [
        "nombre" => "",
        "apellidos" =>"",
        "email" => "",
        "direccion" => "",
        "codigoPostal" => "",
        "localidad" => "",
        "provincia" => "",
        "telefono" => "",
        "nacimiento" => ""
    ];
}

// Funcion para crear la vista del formulario pasandole los nombres necesarios para la cabecera y el boton
$printer = new PrintHtml();
$dataControllerAlta["nombreFormularioCabecera"] = "Registrate";
$dataControllerAlta["nombreFormularioBoton"] = "Registrate";
$form = $printer->createView("Form",$dataControllerAlta);

// Funcion para crear la vista del menu
$menuHtml = $printer->createView("Menu",$dataControllerAlta);

//Crear vista del footer para pintarlo en Alta.html
$footerHtml = $printer->createView("Footer",$dataControllerAlta);

// Array con todos los datos que se van a pintar
$model=[
    "menu" => $menuHtml,
    "formulario" => $form,
    "footer" => $footerHtml 
];

// Funcion para pintar las vistas creadas en el Alta.html
$printer->printView("Alta", $model);

?>