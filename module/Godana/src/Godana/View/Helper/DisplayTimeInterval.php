<?php
namespace Godana\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DisplayTimeInterval extends AbstractHelper
{
    /**
     * __invoke
     *
     * @access public
     * @return array
     */
    public function __invoke(\DateTime $from, \DateTime $to = null)
    {    	
    	if (null === $to) {
            $to = new \DateTime();
        }
        
    	$interval = $to->diff($from);
        return $interval->format('%d days ago');
    }

}