<?php
$data = json_decode( file_get_contents('php://input') );
header('Content-Type: application/json');
$arrayDatos=(array)$data;
if(count($arrayDatos)>0){
    foreach ($arrayDatos as $key => $value) {

        echo "   Clave   ->    ".$key."   Valor   ->     ".$value; 
    }
}

/*
$modificar = new Admin();
$modificar-> updateUser($datos);*/