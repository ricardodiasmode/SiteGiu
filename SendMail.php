<?php

require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");
require("PHPMailer/src/Exception.php");

if (isset($_POST['Nome']))
{
    $ClientName = $_POST['Nome'];
    $ClientContato = $_POST['Contato'];
    $ClientEstado = $_POST['Estado'];
    $ClientCidade = $_POST['Cidade'];
    $ClientBairro = $_POST['Bairro'];
    $ClientRua = $_POST['Rua'];
    $ClientNumero = $_POST['Numero'];
    $ClientComplemento = $_POST['Complemento'];
    $ClientReferencia = $_POST['Referencia'];
    $ClientRecado = $_POST['Recado'];
    $ClientProducts = $_POST['PurchasedProducts'];
    
    $bodytext = "Nome do cliente: ".$ClientName."\r\n".
    "Contato do cliente: ".$ClientContato."\r\n".
    "Estado do cliente: ".$ClientEstado."\r\n".
    "Cidade do cliente: ".$ClientCidade."\r\n".
    "Bairro do cliente: ".$ClientBairro."\r\n".
    "Rua do cliente: ".$ClientRua."\r\n".
    "Numero do cliente: ".$ClientNumero."\r\n".
    "Complemento do endereco: ".$ClientComplemento."\r\n".
    "Referencia do endereco: ".$ClientReferencia."\r\n".
    "Recado: ".$ClientRecado."\r\n".
    "Pedido: ".$ClientProducts;

    try{
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.live.com";
        $mail->Port = 587; // or 587
        $mail->IsHTML(true);
        $mail->Username = "ricardodiasmode@hotmail.com";
        $mail->Password = "rocky250204";
        $mail->SetFrom('ricardodiasmode@hotmail.com', 'Ricardo'); //Name is optional
        $mail->Subject = 'Pedido de '.$ClientName;
        $mail->Body = $bodytext;
        $mail->AddAddress( 'ricardodiasmode@hotmail.com' );


        $path = 'JoinImages\uploads';
        $files = array_diff(scandir($path), array('.', '..'));
        foreach ($files as $file_to_attach)
        {
            if(str_contains (basename($file_to_attach, ".d").PHP_EOL, $ClientName )
            || str_contains (basename($file_to_attach, ".d").PHP_EOL, "LinkMusicas" ))
            {
                //echo $file_to_attach;
                $mail->AddAttachment( $path . "/" . $file_to_attach );
            }
        }

        if(!$mail->Send()) 
        {
            //echo "Mailer Error: " . $mail->ErrorInfo;
        }
        else 
        {
            $path = 'JoinImages\uploads';
            $files = array_diff(scandir($path), array('.', '..'));
            //echo "Message has been sent";
            foreach ($files as $file_to_delete)
            {
                if(str_contains (basename($file_to_delete, ".d").PHP_EOL, $ClientName ))
                {
                    unlink($path."\\".$file_to_delete);
                }
            }
            header("Location:Catalogo.php");
        }
    }catch(Exception $e) {
        //echo 'Message: ' .$e->getMessage();
      }
}
?>