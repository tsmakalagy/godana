<?php
namespace Godana\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Mail\Message as MailMessage;
use Zend\Mail\Transport\Sendmail;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class Mail implements ServiceManagerAwareInterface
{
	/**
     * @var ServiceManager
     */
    protected $serviceManager;
    
	function sendMail($htmlBody, $textBody, $subject, $from, $to)
	{
	    $htmlPart = new MimePart($htmlBody);
	    $htmlPart->type = "text/html";
	
	    $textPart = new MimePart($textBody);
	    $textPart->type = "text/plain";
	
	    $body = new MimeMessage();
	    $body->setParts(array($textPart, $htmlPart));
	
	    $message = new MailMessage();
	    $message->setFrom($from);
	    $message->addTo($to);
	    $message->setSubject($subject);
	
	    $message->setEncoding("UTF-8");
	    $message->setBody($body);
	    $message->getHeaders()->get('content-type')->setType('multipart/alternative');
		
	    $transport = new Sendmail();
	    $transport->send($message);
	}
    
	/**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $serviceManager
     * @return SendMail
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
}