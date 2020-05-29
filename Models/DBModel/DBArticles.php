<?php
include_once(__DIR__.'/DBConnection.php');
class DBArticles extends DBConection{
    public function getArticle($id){
        $this->conn;
        //tu codigo sql de sacar articulos
      //  print_r($this->conn);
    }

    /* Funcion para sacar un array de articulos pasandole una cadena de texto, filtro Like, usado en producto, 
    tipos de ropa y buscador de ropa del menu principal */

    public function getArticleByString($sentence){
	  	$con= $this->conn;
      $sentence = "%$sentence%";
      $stmt = $con->prepare("SELECT idArticulo,nombre,precio FROM articulos WHERE nombre LIKE ?");
      $stmt->bind_param("s",$sentence);
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

    // Funcion para recoger un articulo pasandole su id correspondiente
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

    // Funcion para sacar el nombre del articulo pasandole su id
    public function getNameArticleById($id){
      $con= $this->conn;
      $num = (int) $id;
      $stmt = $con->prepare("SELECT nombre FROM articulos WHERE idArticulo=?");
      $stmt->bind_param("i",$num);
		  $stmt -> execute();
      $result = $stmt->get_result();  
      $nameData="";
		  if($myrow = $result->fetch_assoc()) {
          $nameData = $myrow["nombre"];
      }
      $stmt->free_result();
      $stmt->close();
      return $nameData;
      
    }

    // Funcion para añadir a la cesta un producto en el caso de que ya se haya añadido
    public function addShopCart($arrayShopCart, $newAddProduct){
      $idProduct=$newAddProduct["idProducto"];
      foreach ($arrayShopCart as $key => $value) {
        if($value["idProducto"] == $idProduct){
            $arrayShopCart[$key]["lotProduct"] = $value["lotProduct"]+$newAddProduct["lotProduct"];
            return $arrayShopCart;
        }
      }

      $arrayShopCart[] = $newAddProduct;
      
      return $arrayShopCart;
    }

    public function getAllArticles(){

      $con= $this->conn;
      $stmt = $con->prepare("SELECT idArticulo,stock FROM articulos");
		  $stmt -> execute();
      $result = $stmt->get_result();  
      $arrayDatos=[];
		  while($myrow = $result->fetch_assoc()) {
          $articleArray= [];
          $articleArray["idArticulo"] = $myrow["idArticulo"];
          $articleArray["stock"] = $myrow["stock"];
          $arrayDatos[]=$articleArray;
      }
      $stmt->free_result();
      $stmt->close();
      return $arrayDatos;
    }
}