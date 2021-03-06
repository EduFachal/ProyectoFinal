<?php
include_once("../Models/DBModel/DBArticles.php");
class Users extends DBConection{
    function __construct(){
        parent::__construct();
    }
    // Funcion multitabla para sacar los datos de las facturas como una array pasandole el ID del usuario
    public function getFacturas($id){
        $con= $this->conn;
        $intId= (int) $id;
        $stmt = $con->prepare("SELECT idFactura,fecha,precio FROM facturas,datosclientes WHERE datosclientes.idCliente=facturas.idCliente_datos AND datosclientes.idUsuario_user=?");
        $stmt->bind_param("i",$intId);
        $stmt -> execute();
        $result = $stmt->get_result();  
        $arrayDatos=[];
        while($myrow = $result->fetch_assoc()) {
            $articleArray= [];
            $articleArray["idFactura"] = $myrow["idFactura"];
            $articleArray["fecha"] = $myrow["fecha"];
            $articleArray["precio"] = $myrow["precio"];
            $arrayDatos[] = $articleArray;
        }
        $stmt->free_result();
        $stmt->close();
        return $arrayDatos;
  }

  //Funcion para meter un array de facturas y sacar un string en forma de filas para pintarlo posteriormente
  public function stringFacturas($arrayFacturas){
    $facturas="";
    for ($i=0; $i < count($arrayFacturas); $i++) { 
        $facturas.="<tr><td>".$arrayFacturas[$i]["idFactura"]."</td>"
            ."<td>".$arrayFacturas[$i]["fecha"]."</td>"
            ."<td><strong>".$arrayFacturas[$i]["precio"]." €</strong></td>
            .<td><i class='fas fa-file-invoice-dollar getBill' id='imageBill' data-id='".$arrayFacturas[$i]["idFactura"]."'></i></td></tr>";
    }
    return $facturas;
  }

  // Funcion para sacar todo el cesto de la compra en Cesta.html
  public function getShoppingCart($arrayProducts){
    $price;
    $priceTotal=0;
    $cart="";
    $productName="";
    $article = new DBArticles();
    for ($i=0; $i < count($arrayProducts); $i++) { 
        $price=$arrayProducts[$i]["lotProduct"]*$arrayProducts[$i]["productPrice"];
        $priceTotal=$price+$priceTotal;
        $productName = $article -> getNameArticleById($arrayProducts[$i]["idProducto"]);
        $cart.="<tr><td>".$productName."</td>"
            ."<td>".$arrayProducts[$i]["lotProduct"]."</td>"
            ."<td class='totalPrice'>".$price."</td>"
            ."<td><i class='fas fa-times deleteButton' data-id='".$arrayProducts[$i]["idProducto"]."'></td></tr>";
    }
    $arrayDataShoppingCart=[
        "printDataProducts" => $cart,
        "priceTotal" => $priceTotal];
    return $arrayDataShoppingCart;
  }

  // Funcion para sacar todo el cesto de la compra en Cesta.html
  public function deleteProductShoppingCart($idProduct,$arrayProducts){
    $newArrayProduct=[];
     foreach ($arrayProducts as $key => $value) {
         if($value["idProducto"]!=$idProduct){
            $newArrayProduct[] = $value;
         }
     }
     return $newArrayProduct;
   }

   // Función para validar la compra del usuario y actualizar los datos de Stock del producto
   public function finishPurchase($shop,$price,$data,$user){

        $con=$this ->conn;
        $validate=false;
        // Comprueba si hay stock para poder hacer la operacion
        $validate=$this->checkStock($data);
        if($validate){
            //Sacar la fecha del momento del dia
            $hoy = getdate();
            $fecha =$hoy['mday']."/".$hoy["mon"]."/".$hoy["year"];
            $dateF = strval($fecha);
            // Saca el id del cliente pasandole el usuario
            $idClient=(int) $this->getIdCliente($user);
            // Inserta la factura correspondiente
            $stmt = $con->prepare("INSERT INTO facturas (fecha,precio,tiendaDestino,idCliente_datos) VALUES (?,?,?,?)");
            $stmt->bind_param("sssi",$dateF,$price,$shop,$idClient);
            if($stmt->execute()){
                $stmt->close();
                $intIdFactura= (int) $this->idFactura($user,$dateF,$price);
                foreach ($data as $key => $value) {
                    // Va introduciendo cada uno de los articulos correspondientes
                    $stmt = $con->prepare("INSERT INTO pedidos (unidades,precioTotal,idFactura_fact,idArticulo_art) VALUES (?,?,?,?)");
                    $calculatePrice = (int)$value["lotProduct"]*$value["productPrice"];
                    $stmt->bind_param("ssii",$value["lotProduct"],$calculatePrice,$intIdFactura,$value["idProducto"]);
                    $stmt->execute();
                    $stmt->close(); 
                    $stockDbArticle= $this-> checkStockArticle($value["idProducto"]);
                    $endStock = $stockDbArticle - $value["lotProduct"];
                    $intEndStock= (int) $endStock;
                    if($intEndStock>-1){
                        $stmt = $con->prepare("UPDATE articulos SET stock=? WHERE idArticulo=?");
                        $stmt->bind_param("ii",$intEndStock,$value["idProducto"]);
                        if($stmt ->execute()){
                            $validate=true;
                        }
        				$stmt->close();
                    }  
                }           
            } 
        }
        return $validate;
   }

   // Función para sacar el idCliente pasandole el idUsuario(String)
    public function getIdCliente($userId){
        $con = $this ->conn;
        $intId= (int) $userId;
        $stmt = $con ->prepare("SELECT idCliente FROM datosclientes WHERE idUsuario_user=?");
        $stmt->bind_param("i",$intId);
        $stmt -> execute();
        $result = $stmt->get_result();  
        $value="";
        if($myrow = $result->fetch_assoc()) {
            $value=$myrow["idCliente"];
        }
        $stmt->close();
        return $value;
    }

    // Función para sacar el idFactura psandole el idUsuario(String)
    public function idFactura($userId,$date,$price){
        $con = $this ->conn;
        $intId= (int) $userId;
        $stmt = $con ->prepare("SELECT idFactura FROM facturas,datosclientes WHERE facturas.idCliente_datos=datosclientes.idCliente AND idUsuario_user=? AND fecha=? AND precio=?");
        $stmt->bind_param("iss",$intId,$date,$price);
        $stmt -> execute();
        $result = $stmt->get_result();  
        $value="";
        if($myrow = $result->fetch_assoc()) {
            $value=$myrow["idFactura"];
        }
        $stmt->close();
        return $value;
    }

    // Función para comprobar si existe el producto deseado y si hay stock disponible, recibe un array con esos datos(String)
    public function checkStock($arrayDataProducts){
        $articles = new DBArticles();
        $allArticles = $articles -> getAllArticles();
        $validate=false;
        foreach ($arrayDataProducts as $key => $value) {
            for ($i=0; $i <count($allArticles) ; $i++) { 
               if($allArticles[$i]["idArticulo"]==$value["idProducto"] && $value["lotProduct"]<=$allArticles[$i]["stock"]){
                   $validate=true;
               }
            }
        }
        return $validate;
        
    }

    // Función para sacar el stock disponible de un articulo en particular, se le pasa su id(String) por paramentro 
    public function checkStockArticle($article){
        $con = $this ->conn;
        $intId= (int) $article;
        $stmt = $con ->prepare("SELECT stock FROM articulos WHERE idArticulo=?");
        $stmt->bind_param("i",$intId);
        $stmt -> execute();
        $result = $stmt->get_result();  
        $value="";
        if($myrow = $result->fetch_assoc()) {
            $value=$myrow["stock"];
        }
        $stmt->close();
        return $value;  
    }

    public function getEmail($user){
        $con = $this ->conn;
        $stmt = $con ->prepare("SELECT email FROM usuarios, datosclientes WHERE datosclientes.idUsuario_user=usuarios.idUsuario AND usuarios.usuario=?");
        $stmt->bind_param("s",$user);
        $stmt -> execute();
        $result = $stmt->get_result();  
        $value="";
        if($myrow = $result->fetch_assoc()) {
            $value=$myrow["email"];
        }
        $stmt->close();
        return $value; 
    }

    
    public function getValuesUser($idUser){
        $con = $this ->conn;
        $intId= (int) $idUser;
        $stmt = $con ->prepare("SELECT usuario,nombre,apellidos,fechaNacimiento,telefono,email,direccion,codigoPostal,localidad,provincia FROM usuarios, datosclientes WHERE datosclientes.idUsuario_user=usuarios.idUsuario AND datosclientes.idUsuario_user=?");
        $stmt->bind_param("i",$intId);
        $stmt -> execute();
        $result = $stmt->get_result();  
        $value=[];
        if($myrow = $result->fetch_assoc()) {
            $value=[
                "usuario" => $myrow["usuario"],
                "nombre" => $myrow["nombre"],
                "apellidos" => $myrow["apellidos"],
                "fechaNacimiento" => $myrow["fechaNacimiento"],
                "telefono" => $myrow["telefono"],
                "email" => $myrow["email"],
                "direccion" => $myrow["direccion"],
                "codigoPostal" => $myrow["codigoPostal"],
                "localidad" => $myrow["localidad"],
                "provincia" => $myrow["provincia"]];
        }
        $stmt->close();
        return $value; 
    }

    public function getProductsBill($billId){
        $con = $this ->conn;
        $intId= (int) $billId;
        $stmt = $con ->prepare("SELECT unidades,precioTotal,nombre FROM pedidos,articulos WHERE pedidos.idArticulo_art=articulos.idArticulo AND idFactura_fact=?");
        $stmt->bind_param("i",$intId);
        $stmt -> execute();
        $result = $stmt->get_result();  
        $arrayDatos=[];
        while($myrow = $result->fetch_assoc()) {
            $articleArray= [];
            $articleArray["unidades"] = $myrow["unidades"];
            $articleArray["precioTotal"] = $myrow["precioTotal"];
            $articleArray["nombre"] = $myrow["nombre"];
            $arrayDatos[] = $articleArray;
        }
        $stmt->free_result();
        $stmt->close();
        return $arrayDatos;
    }
}

