<?php
include_once('../Models/PHPMailer/src/PHPMailer.php');
include_once('../Models/PHPMailer/src/Exception.php');
include_once('../Models/PHPMailer/src/OAuth.php');
include_once('../Models/PHPMailer/src/SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EMail{
    public function sendMail($from,$to,$subejct,$body){
    
    $mail = new PHPMailer;
    
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
    $mail->Username = "proyectofinaldawiessjdlc@gmail.com"; // Correo completo a utilizar
    $mail->Password = "caca1991"; // Contraseña
    $mail->Port = 587; // Puerto a utilizar
    $mail->From = $from; // Desde donde enviamos (Para mostrar)
    $mail->FromName = "EMOP Tienda de Deportes";
    $mail->AddAddress($to); // Esta es la dirección a donde enviamos
    $body = "Te queremos dar la bienvenida a nuestra tienda<br />";
    $body .= "Disfruta de nuestras ofertas!!<br><br><br>";
    $body .="<img src='http://localhost/1eva/ProyectoFinal/Public/Img/fav-ico_nofondo_2.png'>";
    $mail->IsHTML(true); // El correo se envía como HTML
    $mail->Subject = $subejct; // Este es el titulo del email.
    $mail->Body = $body; // Mensaje a enviar
    $mail->AltBody = "Hola mundo. Esta es la primer línean Acá continuo el mensaje"; // Texto sin html
    $validate = $mail->Send(); // Envía el correo.
    
    if($validate){
    return true;
    }else{
        return false;
        
    }
}

public function sendMailDefault(){
    
    $mail = new PHPMailer;
    
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
    $mail->Username = "proyectofinaldawiessjdlc@gmail.com"; // Correo completo a utilizar
    $mail->Password = "caca1991"; // Contraseña
    $mail->Port = 587; // Puerto a utilizar
    $mail->From = "proyectofinaldawiessjdlc@gmail.com"; // Desde donde enviamos (Para mostrar)
    $mail->FromName = "EMOP Tienda de Deportes";
    $mail->AddAddress("proyectofinaldawiessjdlc@gmail.com"); // Esta es la dirección a donde enviamos
    
    $mail->IsHTML(true); // El correo se envía como HTML
    $mail->Subject = "EMOP Tienda de Deportes"; // Este es el titulo del email.
    $body = "Te queremos dar la bienvenida a nuestra tienda<br />";
    $body .= "Disfruta de nuestras ofertas!!<br><br><br>";
    $body .="<img src='../Public/Img/fav-ico_nofondo_2.png'>";
    $mail->Body = $body; // Mensaje a enviar
    $mail->AltBody = "Hola mundo. Esta es la primer línean Acá continuo el mensaje"; // Texto sin html
    $validate = $mail->Send(); // Envía el correo.
    
    if($validate){
    return true;
    }else{
        return false;
        
    }
}

public function sendMailValidateChangePassword($to){
    
    $mail = new PHPMailer;
    
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
    $mail->Username = "proyectofinaldawiessjdlc@gmail.com"; // Correo completo a utilizar
    $mail->Password = "caca1991"; // Contraseña
    $mail->Port = 587; // Puerto a utilizar
    $mail->From = "proyectofinaldawiessjdlc@gmail.com"; // Desde donde enviamos (Para mostrar)
    $mail->FromName = "EMOP Tienda de Deportes";
    $mail->AddAddress($to); // Esta es la dirección a donde enviamos
    
    $mail->IsHTML(true); // El correo se envía como HTML
    $mail->Subject = "EMOP Tienda de Deportes"; // Este es el titulo del email.
    $body = "<p style='font-size:2em'>Muchas gracias por ponerse en contacto para recuperar su contraseña<br />";
    $body .= "Por favor, entre en este link para guardar la nueva<br>Esperemos que este todo de su agrado</p><br><br>";
    $body .="<img src='../Public/Img/fav-ico_nofondo_2.png'>";
    $mail->Body = $body; // Mensaje a enviar
    $mail->AltBody = "Hola mundo. Esta es la primer línean Acá continuo el mensaje"; // Texto sin html
    $validate = $mail->Send(); // Envía el correo.
    
    if($validate){
    return true;
    }else{
        return false;
        
    }
}
}


 