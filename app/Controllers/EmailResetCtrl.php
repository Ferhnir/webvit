<?php

namespace App\Controllers;

use Slim\Views\Twig as View;
use App\Controllers\Controller;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailResetCtrl extends Controller
{
    
    public function forgotPassword($request, $response)
    {

        return $this->view->render($response, './email/forgot_password.twig'); 

    }

    public function sentResetPasswordEmail($request, $response, $app)
    {
        try {

        $mail = new PHPMailer;
    
        $mail->SMTPDebug = 3;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'localhost';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = '';                 // SMTP username
        $mail->Password = 'silent1984';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
    
        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('zax1984@gmail.com', 'Maksymilian Zdunski');     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('no-reply@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
    
        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

        

        } catch (Exception $e) {

            $this->flash->addMessage('error',$e->errorMessage());
            return $response->withRedirect($this->router->pathFor('email.forgot.password'));

        } catch (\Exception $e) { //The leading slash means the Global PHP Exception class will be caught

            $this->flash->addMessage('error',$e->errorMessage());
            return $response->withRedirect($this->router->pathFor('email.forgot.password'));

        }

    }

    public function resetPasswordEmailSent($request, $response)
    {

        return $this->view->render($response, './email/reset_password_email_sent.twig');

    }

}