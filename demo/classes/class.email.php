<?php
/*


This class is just to send an email
*/
class Email
{

     private $to;
	 private $subject;
	 private $body;
	 private $html = null; 
	 private $headers;
	 private $replyTo = NOTIFICATION_EMAIL;
	 private $from = SITE_NAME;
	 
	 function __construct($to, $subject, $body, $html = null)
	 {
			if(!validEmail($to))
			{
			     return false;
			}
			
			$this->to = $to;
			$this->subject = $subject;
			$this->body = $body;
			if($html)
			{
			    $this->html = 1;
			}
			
			$this->setHeaders(); //set headers
			   
	 }
	 
	 public function setHeaders()
	 {
	       //$this->headers  = "To: ".$this->to."\r\n";
			$this->headers = "From: \"".$this->from."\" <".$this->replyTo.">\r\n";
			if($this->html)
			{
			    $this->headers .= "MIME-Version: 1.0\r\n";
				$this->headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$this->headers .= "X-Mailer: PHP/". phpversion();

			}
	 }
	 
	 function sendMail()
	 {
		 

	 
	     if(!empty($this->to) || !empty($this->subject) || !empty($this->body))
		 {

		     if(mail($this->to, $this->subject, $this->body, $this->headers))
			 {
			 		
			     return true;
			 }else
			 {
			    
			     return false;
			 }
		 }
	 }

}

?>