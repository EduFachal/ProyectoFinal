<?php
/*
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
        usuario varchar(45),
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
            REFERENCES usuarios(idUsuario));")){
                die("Fallo en la creacion de la tabla datosClientes".$con->error);
                $con=null;
                $con->close();
        }

        // Crea tabla facturas
        if(!$con->query("CREATE TABLE IF NOT EXISTS proyecto.facturas(
            idFactura int AUTO_INCREMENT,
            fecha varchar(80),
            precio decimal(10,2),
            idCliente_datos int,
            CONSTRAINT PK_USERS PRIMARY KEY (idFactura),
            CONSTRAINT FK_FACTURADATACLIENT_IDCLIENT FOREIGN KEY (idCliente_datos)
            REFERENCES datosClientes(idCliente));")){
                die("Fallo en la creacion de la tabla facturas".$con->error);
                $con=null;
                $con->close();
        }
    
        // Crea tabla pedidos
        if(!$con->query("CREATE TABLE IF NOT EXISTS proyecto.pedidos(
            unidades int,
            precioTotal decimal(10,2),
            idFactura_fact int,
            idArticulo_art int,
            stock int,
            CONSTRAINT FK_PEDIDOSFACTURA_IDFACT FOREIGN KEY (idFactura_fact)
            REFERENCES facturas(idFactura),
            CONSTRAINT FK_PEDIDOSARTICULO_IDART FOREIGN KEY (idArticulo_art)
            REFERENCES articulos(idArticulo));")){
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

        $usuarios=array("alexsn","mariasa","danife","miguelgg","teemo");
        $pass=array("a1234","b4789","c6598","d546213","e1546");

        for($i=0;$i<count($usuarios);$i++) {
            $hash=password_hash($pass[$i],PASSWORD_DEFAULT);
            $connex->query("INSERT INTO usuarios VALUES ('($i+1)',1,'$usuarios[$i]','$hash')");
            echo "//////////////////";
            print_r($connex);
        }
    }else{
        die("No se ha podido conectar ". $connex->connect_error);
		    $connex=null;
		    $connex->close();
    }


*/






    //Crea la base de datos si no existe y lo modifica a UTF8
    function crearBaseDatos($con){

        if(!$con->query("CREATE DATABASE IF NOT EXISTS tienda2") ||
        !$con->query("ALTER DATABASE tienda2 CHARACTER SET utf8 COLLATE utf8_general_ci")){
            die("Fallo en la creacion de la base de datos".$con->error);
            $con=null;
		    $con->close();
        }
    }

    //Crea el usuario y le da privilegios en caso de no existir
    function crearUsuario($con){
        if(!$con->query("CREATE USER IF NOT EXISTS 'tienda2'@'localhost' IDENTIFIED BY 'tienda2'")||
        !$con->query("GRANT select,insert,update,delete ON tienda2.* TO 'tienda2'@'localhost' IDENTIFIED BY 'tienda2'")){
           die("Fallo en la creacion del usuario".$con->error);
           $con=null;
		   $con->close();
       }
    }

    //Crea la tabla users en tienda2 en caso de no existir
    function crearTabla($con){
        if(!$con->query("CREATE TABLE IF NOT EXISTS tienda2.users(
            nombre varchar(30),
            pass varchar(65),
            CONSTRAINT PK_USERS PRIMARY KEY (nombre));")){
                die("Fallo en la creacion de la tabla".$con->error);
                $con=null;
                $con->close();
        }
    }

    function insertarQuery($connex){
        // Genero dos arrays con la informacion que voy a insertar
        $usuarios=array("alexsn","mariasa","danife","miguelgg","teemo");
        $pass=array("a1234","b4789","c6598","d546213","e1546");
        $cont=count($usuarios);

        // Recorro los dos arrays a la vez e insertando la informacion
        for($i=0;$i<$cont;$i++) {
            $stmt=$connex->prepare("INSERT INTO users (nombre,pass) VALUES (?,?)");
            $hash=password_hash($pass[$i],PASSWORD_DEFAULT);
            $stmt->bind_param("ss",$usuarios[$i],$hash);
            $stmt->execute();
            $stmt->close();
        }
    }