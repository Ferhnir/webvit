<?php

namespace App\Controllers;

use App\Controllers\Controller;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailCtrl extends Controller
{

    public function sendEmail($recipment, $token)
    {

        try {

            $mailer = new PHPMailer(true);
            // Passing `true` enables exceptions
            
            //Server settings            
            $mailer->SMTPDebug = 0; // 2 will enable verbose debug output
            
            $mailer->isSMTP(); // Set mailer to use SMTP
            
            $mailer->Host = '92.63.131.250'; // Specify main and backup SMTP servers
            
            $mailer->SMTPAuth = true; // Enable SMTP authentication
            
            $mailer->Username = 'portal@thinkingofyouapp.com'; // SMTP username
            
            $mailer->Password = 'W2p4v06w8z76745ES6QaXQI0C'; // SMTP password
            
            $mailer->SMTPSecure = false; // Enable TLS encryption, `ssl` also accepted
            
            $mailer->SMTPAutoTLS = false; // Enable TLS encryption, `ssl` also accepted
            
            $mailer->Port = 25; // TCP port to connect to
            
            
            //Recipienters
            $mailer->setFrom($mailer->Username,'sdfds');
            
            $mailer->addAddress($recipment); // Add a recipient

            // $mailer->addAddress('zax1984@gmail.com');
                      
            //Contenter
            $mailer->isHTML(true);
            // Set email format to HTML
            
            $mailer->Subject = 'Password reset';
            
            $mailer->Body = '<a href="http://localhost/webvit/password_reset_form?token=' . $token . '">http://localhost/webvit/password_reset_form?token='.$token.'</a>';
            
            $mailer->AltBody = 'testing a mailserver';
            
            
            if(!$mailer->send()) {
            
                $this->exitCode = -2;
            
                return false;
            
            } else { 

                return true; 
            }
            
        } catch(Exception $e) {
            
            // $this->exitCode = -2;
            echo $e;

        }

    }

}