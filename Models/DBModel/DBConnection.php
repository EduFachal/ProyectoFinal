<?php

class DBConection{
    protected $conn;
    function __construct(){
         $this->conn = new mysqli("localhost","tienda2","tienda2","tienda2");
    }
    function newConn(){
         return new mysqli("localhost","tienda2","tienda2","tienda2");
    }
    function destruct(){

		$this->conn->close();
    }
}
/*
$db = new DBConection();
if($db->conn==true){

    if(!$db->query("CREATE DATABASE IF NOT EXISTS tienda2") ||
    !$con->query("ALTER DATABASE tienda2 CHARACTER SET utf8 COLLATE utf8_general_ci")){
        die("Fallo en la creacion de la base de datos".$con->error);
        $con=null;
        $con->close();
    }
    */