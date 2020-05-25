<?php
include_once(__DIR__.'/DBConnection.php');
class DBArticles extends DBConection{
    public function getArticle($id){
        $this->conn;
        //tu codigo sql de sacar articulos
      //  print_r($this->conn);
    }

    public function getArticleByString($cadena){
	  	$con= $this->conn;
      $cadena = "%$cadena%";
      $stmt = $con->prepare("SELECT idArticulo,nombre,precio FROM articulos WHERE nombre LIKE ?");
      $stmt->bind_param("s",$cadena);
		  $stmt -> execute();
      $result = $stmt->get_result();  
      $arrayDatos=[];
		  while($myrow = $result->fetch_assoc()) {
          $articleArray= [];
          $articleArray["idArticulo"] = $myrow["idArticulo"];
          $articleArray["nombre"] = $myrow["nombre"];
          $articleArray["precio"] = $myrow["precio"];
          $arrayDatos[] = $articleArray;
      }
      $stmt->free_result();
      $stmt->close();
      return $arrayDatos; 
    }

    public function getArticleById($id){
      $con= $this->conn;
      $num = (int) $id;
      $stmt = $con->prepare("SELECT idArticulo,nombre,precio FROM articulos WHERE idArticulo=?");
      $stmt->bind_param("i",$num);
		  $stmt -> execute();
      $result = $stmt->get_result();  
      $arrayDatos=[];
		  while($myrow = $result->fetch_assoc()) {
          $arrayDatos["idArticulo"] = $myrow["idArticulo"];
          $arrayDatos["nombre"] = $myrow["nombre"];
          $arrayDatos["precio"] = $myrow["precio"];
      }
      $stmt->free_result();
      $stmt->close();
      return $arrayDatos;
      
    }
}