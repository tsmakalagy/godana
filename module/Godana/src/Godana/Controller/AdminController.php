<?php
namespace Godana\Controller;
 
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController
{
	public function indexAction()
	{
		$view = new ViewModel();
 		$this->layout('layout/sb-admin-layout');
 		return $view;
 	}
}

