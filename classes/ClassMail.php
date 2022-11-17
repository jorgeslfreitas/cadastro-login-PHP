<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class ClassMail{
    private $mail;
    private $exception;

    public function __construct()
    {
        $this->mail=new PHPMailer();
    }

    #Envio de email
    public function sendMail($email, $nome, $token=null, $assunto, $corpoEmail)
    {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = HOSTMAIL;
            $this->mail->SMTPAuth = true;
            $this->mail->Username = USERMAIL;
            $this->mail->Password = PASSMAIL;
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port = 587;
            $this->mail->CharSet = 'utf-8';
            $this->mail->SMTPOptions = array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                    "allow_self_signed"=>true
                )
            );

            $this->mail->setFrom('EMAIL', '');
            $this->mail->addAddress($email,$nome);
            $this->mail->isHTML(true);
            $this->mail->Subject = $assunto;
            $this->mail->Body = $corpoEmail;
            $this->mail->send();
            echo 'Mensagem enviada';
        }catch (Exception $e) {
            echo 'A mensagem não pôde ser enviada. Erro do correio: ', $this->mail->ErrorInfo;
        }
    }
}
