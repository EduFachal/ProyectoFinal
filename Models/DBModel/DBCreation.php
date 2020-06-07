<?php

    //Establece la conexion a la base de datos
    $con = new mysqli("localhost","root","","");
  
   if($con==true){

        if(!$con->query("CREATE DATABASE IF NOT EXISTS proyecto") ||
        !$con->query("ALTER DATABASE proyecto CHARACTER SET utf8 COLLATE utf8_general_ci")){
            die("Fallo en la creacion de la base de datos".$con->error);
            $con=null;
		    $con->close();
        }

        if(!$con->query("CREATE USER IF NOT EXISTS 'proyecto'@'localhost' IDENTIFIED BY 'proyecto'")||
        !$con->query("GRANT select,insert,update,delete ON proyecto.* TO 'proyecto'@'localhost' IDENTIFIED BY 'proyecto'")){
           die("Fallo en la creacion del usuario".$con->error);
           $con=null;
		   $con->close();
       }

       // Crea tabla Usuarios
       if(!$con->query("CREATE TABLE IF NOT EXISTS proyecto.usuarios(
        idUsuario int AUTO_INCREMENT,
        rol int(2),
        usuario varchar(45) UNIQUE,
        pass varchar(200),
        CONSTRAINT PK_USERS PRIMARY KEY (idUsuario));")){
            die("Fallo en la creacion de la tabla usuarios".$con->error);
            $con=null;
            $con->close();
        }

        // Crea tabla articulos
        if(!$con->query("CREATE TABLE IF NOT EXISTS proyecto.articulos(
            idArticulo int AUTO_INCREMENT,
            nombre varchar(45),
            precio decimal(6,2),
            stock int,
            CONSTRAINT PK_ARTICLES PRIMARY KEY (idArticulo));")){
                die("Fallo en la creacion de la tabla articulos".$con->error);
                $con=null;
                $con->close();
        }

        // Crea tabla datosClientes
        if(!$con->query("CREATE TABLE IF NOT EXISTS proyecto.datosClientes(
            idCliente int AUTO_INCREMENT,
            nombre varchar(45),
            apellidos varchar(60),
            fechaNacimiento varchar(25),
            telefono varchar(15),
            email varchar(90),
            direccion varchar(200),
            codigoPostal varchar(10),
            localidad varchar(60),
            provincia varchar(60),
            idUsuario_user int,
            CONSTRAINT PK_DATA_CLIENT PRIMARY KEY (idCliente),
            CONSTRAINT FK_DATAUSER_IDUSER FOREIGN KEY (idUsuario_user)
            REFERENCES usuarios(idUsuario) on delete cascade on update cascade);")){
                die("Fallo en la creacion de la tabla datosClientes".$con->error);
                $con=null;
                $con->close();
        }

        // Crea tabla facturas
        if(!$con->query("CREATE TABLE IF NOT EXISTS proyecto.facturas(
            idFactura int AUTO_INCREMENT,
            fecha varchar(80),
            precio decimal(10,2),
            tiendaDestino varchar(60),
            idCliente_datos int,
            CONSTRAINT PK_USERS PRIMARY KEY (idFactura),
            CONSTRAINT FK_FACTURADATACLIENT_IDCLIENT FOREIGN KEY (idCliente_datos)
            REFERENCES datosClientes(idCliente) on delete cascade on update cascade);")){
                die("Fallo en la creacion de la tabla facturas".$con->error);
                $con=null;
                $con->close();
        }
    
        // Crea tabla pedidos
        if(!$con->query("CREATE TABLE IF NOT EXISTS proyecto.pedidos(
            unidades varchar(100),
            precioTotal decimal(10,2),
            idFactura_fact int,
            idArticulo_art int,
            CONSTRAINT FK_PEDIDOSFACTURA_IDFACT FOREIGN KEY (idFactura_fact)
            REFERENCES facturas(idFactura) on delete cascade on update cascade,
            CONSTRAINT FK_PEDIDOSARTICULO_IDART FOREIGN KEY (idArticulo_art)
            REFERENCES articulos(idArticulo) on delete cascade on update cascade);")){
                die("Fallo en la creacion de la tabla pedidos".$con->error);
                $con=null;
                $con->close();
        }
         if(!$con->query("CREATE TABLE IF NOT EXISTS proyecto.passtemp(
            id varchar(40) UNIQUE,
            idUser int,
            pass varchar(200));")){
                die("Fallo en la creacion de la tabla pedidos".$con->error);
                $con=null;
                $con->close();
        }

        $con->close();
        
    }else{

        die("No se ha podido conectar ". $con->connect_error);
		    $con=null;
		    $con->close(); 
    }

    //Establece la conexion al usuario tienda2
    $connex=new mysqli("localhost","proyecto","proyecto","proyecto");

    if($connex==true){
        aniadirArticulos($connex);
        $usuarios=array("alexsn","mariasa","danife","miguelgg","teemo");
        $pass=array("a1234","b4789","c6598","d546213","e1546");
        $datos=array("Fulanito","Menganito","11/11/2011","555555555","dasdadas@dsadsad.es","jhgffghfgh","1234","dsadasdads","gfhfghfg");

        for($i=0;$i<count($usuarios);$i++) {
            $hash=password_hash($pass[$i],PASSWORD_DEFAULT);
            $connex->query("INSERT INTO usuarios (idUsuario, rol,usuario,pass) VALUES ($i,1,'$usuarios[$i]','$hash')");
            $connex->query("INSERT INTO datosclientes (nombre,apellidos,fechaNacimiento,telefono,email,direccion,codigoPostal,localidad,provincia,idUsuario_user) VALUES 
                    ('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]','$datos[8]',$i)");
        }
        
        //Para admin
        $hash=password_hash("admin",PASSWORD_DEFAULT);
        $connex->query("INSERT INTO usuarios (rol,usuario,pass) VALUES (0,'admin','$hash')");
    }else{
        die("No se ha podido conectar ". $connex->connect_error);
		    $connex=null;
		    $connex->close();
    }


  


    function aniadirArticulos($connex){
        $nombresArticulos=array(
            'camiseta vans amarilla hombre','camiseta vans morada hombre','camiseta nike negra hombre','pantalon adidas negro hombre','pantalon puma negro hombre','pantalon fila azul hombre','zapatillas nike negro hombre','zapatillas nike rojo hombre','zapatillas adidas rojo hombre',
            'camiseta fila negra mujer','camiseta puma blanca mujer','camiseta puma rosa mujer','pantalon puma negro mujer','pantalon boriken negro mujer','pantalon boriken gris mujer','zapatillas nike negro mujer','zapatillas puma blancas mujer','zapatillas fila gris mujer',
            'camiseta puma naranja kids','camiseta puma blanca kids','camiseta nike amarilla kids','pantalon fila negro kids','pantalon nike gris kids','pantalon fila gris kids','zapatillas converse blanca kids','zapatillas fila gris kids','zapatillas nike blanca kids');

        $precios=array(7.99, 12.99, 9.99, 11.90,5.90, 6.90 , 18.99, 49.99, 11.90,5.90, 6.90 , 17.90, 7.99, 9.99, 19.99, 21.90, 7.99, 12.99, 9.99, 11.90,7.99, 12.99, 9.99, 11.90, 22.99, 19.99, 31.90);

        $stock=array(30, 35, 40, 40,20,15,20,30,35,25,20,10,15, 15, 20, 25, 30, 35, 40, 45, 25, 30, 35, 40, 45,50,60);

        $sql ="INSERT INTO articulos (nombre,precio,stock) VALUES";

        for($i=0;$i<count($nombresArticulos);$i++){
            $sql.="('".$nombresArticulos[$i]."',".$precios[$i].",".$stock[$i]."),";
        }
        $sql = rtrim($sql, ',');

        $connex->query($sql);
    }
