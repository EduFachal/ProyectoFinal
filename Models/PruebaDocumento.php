<?php
/*session_start();
  header("Content-type: application/vnd.ms-word");
  header("Content-Disposition: attachment;Filename=".$_SESSION["idUsuario"].".doc");    
  echo "<html>";
  echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
  echo "<body>";
  echo "<b>".$_SESSION["idUsuario"]."</b>";
  echo "</body>";
  echo "</html>";*/
 
  include_once('./PHPMailer/src/PHPMailer.php');
  include_once('./PHPMailer/src/Exception.php');
  include_once('./PHPMailer/src/OAuth.php');
  include_once('./PHPMailer/src/SMTP.php');
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  $mail = new PHPMailer;
  
  //Tell PHPMailer to use SMTP
  $mail->SMTPDebug = 2; 
  $mail->isSMTP();
  $mail->SMTPAuth = true;
  $mail->Host = "smtp.gmail.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
  $mail->Username = "proyectofinaldawiessjdlc@gmail.com"; // Correo completo a utilizar
  $mail->Password = "caca1991"; // Contraseña
  $mail->Port = 587; // Puerto a utilizar
  $mail->From = "proyectofinaldawiessjdlc@gmail.com"; // Desde donde enviamos (Para mostrar)
  $mail->FromName = "ELSERVER.COM";
  $mail->AddAddress("proyectofinaldawiessjdlc@gmail.com"); // Esta es la dirección a donde enviamos
  
  $mail->IsHTML(true); // El correo se envía como HTML
  $mail->Subject = "Titulo"; // Este es el titulo del email.
  $body = "Hola mundo. Esta es la primer línea<br />";
  $body .= "Puto<strong>mensaje</strong>";
  $body .= "<a href='http://localhost/1eva/ProyectoFinal/Controllers/Index.php'>Validar contraseña</a>";
  $mail->Body = $body; // Mensaje a enviar
  $mail->AltBody = "Hola mundo. Esta es la primer línean Acá continuo el mensaje"; // Texto sin html
  $exito = $mail->Send(); // Envía el correo.
  
  if($exito){
  echo "El correo fue enviado correctamente.";
  }else{
      print_r($mail);
  echo "Hubo un inconveniente. Contacta a un administrador.";
  }
