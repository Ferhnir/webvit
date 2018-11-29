<?php

namespace App\Controllers;

use App\Controllers\Controller;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Slim\Http\Request;

class MailCtrl extends Controller
{
    protected $email_link;

    // public function __construct(Request $request)
    // {

    //     $route = $request->getUri();

    //     $this->email_link = $route->getBaseUrl().'/'.$route->getPathFor('auth.password.change');

    // }
    
    public function setHostPath(Request $uri){

        
        $this->email_link = $uri->getUri()->getScheme().'://'.$uri->getUri()->getHost().$this->getPathFor('auth.password.change');

    }

    public function sendEmail($recipment, $token)
    {
        
        try {

            $mailer = new PHPMailer(true);
            // Passing `true` enables exceptions
            
            //Server settings            
            $mailer->SMTPDebug = 0; // 2 will enable verbose debug output
            
            $mailer->isSMTP(); // Set mailer to use SMTP
            
            $mailer->Host =  $this->ci['smtp']['host']; // Specify main and backup SMTP servers
            
            $mailer->SMTPAuth = true; // Enable SMTP authentication
            
            $mailer->Username =  $this->ci['smtp']['user']; // SMTP username
            
            $mailer->Password =  $this->ci['smtp']['password']; // SMTP password
            
            $mailer->SMTPSecure = false; // Enable TLS encryption, `ssl` also accepted
            
            $mailer->SMTPAutoTLS = false; // Enable TLS encryption, `ssl` also accepted
            
            $mailer->Port = 25; // TCP port to connect to
            
            
            //Recipienters
            $mailer->setFrom($mailer->Username,  $this->ci['smtp']['sent_from']);
            
            $mailer->addAddress($recipment); // Add a recipient

            //Contenter
            $mailer->isHTML(true);
            // Set email format to HTML
            
            $mailer->Subject = 'Password reset';
            
            $mailer->Body = '<a href="'. $this->email_link .'?token=' . $token . '">'. $this->email_link .'?token='.$token.'</a>';
            
            $mailer->AltBody = 'testing a mailserver';
            
            
            if(!$mailer->send()) {
            
                $this->exitCode = -2;
            
                return false;
            
            } else { 

                return true; 
            }
            
        } catch(Exception $e) {

            echo $e;

        }

    }

}