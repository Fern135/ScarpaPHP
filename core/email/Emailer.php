<?php

namespace Scarpa\email\Emailer;

use Scarpa\lib\util\Util;
use Exception;

class Emailer{
    private $to;
    private $subject;
    private $message;
    private $headers;

    public function __construct($to) {
        $this->ut       = new Util();
        $this->to       = $to;
        $this->subject  = null;
        $this->headers  = "MIME-Version: 1.0" . "\r\n";
        $this->headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    }

    public function __destruct(){
        $this->to       = null;
        $this->subject  = null;
        $this->headers  = null;
        $this->headers  = null;
    }

    public function setSubject($subject){
        if(!empty($subject)){
            $this->subject = $subject;
        }else{
            throw new Exception("Subject cannot be null");
        }

        return $this;
    }

    public function setMessage($message) {
        if(!empty($message)){
            $this->message = $message;
        }else{
            throw new Exception("Message cannot be null");
        }
        return $this;
    }

    public function send() {
        try{
            if(isset($this->subject) &&  isset($this->message)) {
                if (mail( $this->to, $this->subject,  $this->message,  $this->headers )) {
                    return true; // Email sent successfully
                } 
            }
            
            return false; // Email sending failed
        }catch(Exception $error){
            return $error;
        }
    }
}

// Example usage:
// $Emailer = new Emailer("recipient@example.com");

// $htmlMessage = "<html><body>";
// $htmlMessage .= "<h1>Hello, World!</h1>";
// $htmlMessage .= "<p>This is a test email with HTML content.</p>";
// $htmlMessage .= "</body></html>";

// $Emailer->setMessage($htmlMessage);

// if ($Emailer->send()) {
//     echo "Email sent successfully!";
// } else {
//     echo "Email sending failed.";
// }
