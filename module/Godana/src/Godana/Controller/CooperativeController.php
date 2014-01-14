<?php
namespace Godana\Controller;

use Godana\Entity\Reservation;
use Godana\Entity\ReservationBoard;
use Godana\Entity\LineCar;
use Godana\Entity\Car;
use Godana\Entity\CarDriver;
use Godana\Entity\CarModel;
use Godana\Entity\CarMake;
use Godana\Entity\Contact;
use Godana\Entity\LineContact;
use Godana\Entity\Cooperative;
use Godana\Entity\Line;
use Godana\Entity\Zone;

use Zend\Http\PhpEnvironment\Response as Response;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CooperativeController extends AbstractActionController
{
	
	const ROUTE_CREATE_COOPERATIVE = 'admin/cooperative/create';
	const ROUTE_CREATE_ZONE = 'admin/cooperative/zone_create';
	const ROUTE_CREATE_LINE = 'admin/cooperative/line_create';
	const ROUTE_ADD_LINE = 'admin/cooperative/line_add';
	const ROUTE_ADD_MAKE = 'admin/cooperative/car_make_add';
	const ROUTE_ADD_MODEL = 'admin/cooperative/car_model_add';
	const ROUTE_ADD_DRIVER = 'admin/cooperative/car_driver_add';
	const ROUTE_ADD_CAR = 'admin/cooperative/car_add';
	const ROUTE_ADD_LINE_CAR = 'admin/cooperative/line_car_add';
	const ROUTE_CREATE_RESERVATION_BORD = 'admin/cooperative/reservation_board_create';
	const ROUTE_CREATE_RESERVATION = 'admin/cooperative/reservation_create';
	
	/**
     * @var Form
     */
    protected $zoneForm;
    
    /**
     * @var Form
     */
    protected $lineForm;
    
    /**
     * @var Form
     */
    protected $cooperativeForm;
    
    /**
     * @var Form
     */
    protected $cooperativeLineForm;
    
    /**
     * @var Form
     */
    protected $carMakeForm;
    
    /**
     * @var Form
     */
    protected $carModelForm;
    
    /**
     * @var Form
     */
    protected $carDriverForm;
    
    /**
     * @var Form
     */
    protected $carForm;
    
    /**
     * @var Form
     */
    protected $lineCarForm;
    
    /**
     * @var Form
     */
    protected $reservationBoardForm;
    
    /**
     * @var Form
     */
    protected $reservationForm;
    
    
    /**
     * @var ObjectManager
     */
    protected $objectManager;
    
    public function createCooperativeAction()
    {
    	$this->layout('layout/admin-layout');
		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getCooperativeForm();
	    
	    $cooperative = new Cooperative();
	    $form->bind($cooperative);
	    $url = $this->url()->fromRoute(static::ROUTE_CREATE_COOPERATIVE, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'cooperativeForm' => $form,
		    	'lang' => $lang,
		    );
        }
        $post = $prg; 
	    
        $form->setData($post);
        if ($form->isValid()) {
     		$om->persist($cooperative);
            $om->flush();	
            return array(
				'status' => true,
		    	'cooperativeForm' => $form,
		    	'lang' => $lang,
		    );			
        }
        return array(
	    	'cooperativeForm' => $form,
	    	'lang' => $lang,
	    );
    }
    
	public function addlineAction()
    {
    	$this->layout('layout/admin-layout');
		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getCooperativeLineForm();
	    
	    $cooperative = new Cooperative();
	    $form->bind($cooperative);
	    
	    $zoneId = $this->params()->fromQuery('zoneId', null);
	    $cooperativeId = $this->params()->fromQuery('cooperativeId', null);
	    $type = $this->params()->fromQuery('type', null);
	    if ($zoneId != null && $cooperativeId != null) {
	    	$lines = $om->getRepository('Godana\Entity\Line')->findLinesByZoneAndNotCooperative($zoneId, $cooperativeId);
	    	$result = array();
	    	foreach ($lines as $line) {
	    		$departure = $line->getDeparture()->getCityAccented();
	    		$arrival = $line->getArrival()->getCityAccented();
	    		$lineValue = $departure . ' ==> ' . $arrival;
	    		$res = array('id' => $line->getId(), 'text' => $lineValue);
	    		array_push($result, $res);
	    	}
           	return new \Zend\View\Model\JsonModel($result);
	    }
	    if ($type != null && $type == 'zone') {
	    	$zones = $om->getRepository('Godana\Entity\Zone')->findAll();
	    	$result = array();
	    	foreach ($zones as $zone) {
	    		$res = array('id' => $zone->getId(), 'text' => $zone->getName());
	    		array_push($result, $res);
	    	}
	    	return new \Zend\View\Model\JsonModel($result);
	    }
    	if ($type != null && $type == 'line') {
	    	$lines = $om->getRepository('Godana\Entity\Line')->findAll();
	    	$result = array();
    		foreach ($lines as $line) {
	    		$departure = $line->getDeparture()->getCityAccented();
	    		$arrival = $line->getArrival()->getCityAccented();
	    		$lineValue = $departure . ' ==> ' . $arrival;
	    		$res = array('id' => $line->getId(), 'text' => $lineValue);
	    		array_push($result, $res);
	    	}
	    	return new \Zend\View\Model\JsonModel($result);
	    }
	    
	    $url = $this->url()->fromRoute(static::ROUTE_ADD_LINE, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'cooperativeLineForm' => $form,
		    	'lang' => $lang,
		    );
        }
        $post = $prg; 
        $form->setData($post);	        
        if ($form->isValid()) {
        	$cooperativeForm = $post['cooperative-form'];
	    	$cooperativeId = $cooperativeForm['cooperative'];
	    	$coop = $om->getRepository('Godana\Entity\Cooperative')->find($cooperativeId);
        	$zoneId = $cooperativeForm['zone'];
        	$lineId = $cooperativeForm['line'];
        	
        	
        	$zone = $om->getRepository('Godana\Entity\Zone')->find($zoneId);
        	$line = $om->getRepository('Godana\Entity\Line')->find($lineId);
        	
        	$coop_zones = $coop->getZones();
        	$found = false;
        	foreach ($coop_zones as $coop_zone) {
        		if ($coop_zone->getId() == $zone->getId()) {
        			$found = true;
        			break;
        		}
        	}
        	if (!$found) {
        		$coop->addZone($zone);
        	}       	
        	$coop->addLine($line);
        	$lineContact = new LineContact();
        	$lineContact->setLine($line);
        	
        	$contacts = $cooperativeForm['contacts'];
        	foreach ($contacts as $c) {
        		$contactTypeId = $c['type'];
        		$contactType = $om->getRepository('Godana\Entity\ContactType')->find($contactTypeId);
        		$contactValue = $c['value'];
        		$contact = new Contact();
        		$contact->setType($contactType);
        		$contact->setValue($contactValue);
        		$om->persist($contact);
        		$om->flush();	 
        		$lineContact->addContact($contact);       		
        	}
        	$lineContact->setCooperative($coop);
        	$om->persist($lineContact);
     		$om->persist($coop);
            $om->flush();
			return array(
				'status' => true,
		    	'cooperativeLineForm' => $this->getCooperativeLineForm(),
		    	'lang' => $lang,
		    );
        }
	    
	    return array(
	    	'cooperativeLineForm' => $form,
	    	'lang' => $lang,
	    ); 	
    }
    
	public function createZoneAction()
	{
		$this->layout('layout/admin-layout');
		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getZoneForm();
	    
	    $zone = new Zone();
	    $form->bind($zone);
	    
	    $url = $this->url()->fromRoute(static::ROUTE_CREATE_ZONE, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'zoneForm' => $form,
		    	'lang' => $lang,
		    );
        }
        $post = $prg; 	    
        $form->setData($post); 
        if ($form->isValid()) {
     		$om->persist($zone);
            $om->flush();
			return array(
				'status' => true,
		    	'zoneForm' => $form,
		    	'lang' => $lang,
		    );	
        }	    
	    return array(
	    	'zoneForm' => $form,
	    	'lang' => $lang,
	    ); 	
	}
	
	public function createLineAction()
	{
		$this->layout('layout/admin-layout');
		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getLineForm();
	    
	    $line = new Line();
	    $form->bind($line);
	    
	    $url = $this->url()->fromRoute(static::ROUTE_CREATE_LINE, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'lineForm' => $form,
		    	'lang' => $lang,
		    );
        }
        $post = $prg; 	    
        $form->setData($post); 
        if ($form->isValid()) {
        	$zoneId = $post['zone'];        	
            $zone = $om->find('Godana\Entity\Zone', (int)$zoneId);
            $line->setZone($zone);
     		$om->persist($line);
            $om->flush();
            return array(
            	'status' => true,
		    	'lineForm' => $form,
		    	'lang' => $lang,
		    );
        }
	    
	    return array(
	    	'lineForm' => $form,
	    	'lang' => $lang,
	    );
	}
	
	public function addCarMakeAction()
	{
		$this->layout('layout/admin-layout');
		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getCarMakeForm();
	    
	    $carMake = new CarMake();
	    $form->bind($carMake);
	    
	    $url = $this->url()->fromRoute(static::ROUTE_ADD_MAKE, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'carMakeForm' => $form,
		    	'lang' => $lang,
		    );
        }
        $post = $prg; 	    
        $form->setData($post);
        if ($form->isValid()) {	        	
     		$om->persist($carMake);
            $om->flush();
            return array(
				'status' => true,
		    	'carMakeForm' => $form,
		    	'lang' => $lang,
		    );
        }	    
	    return array(
	    	'carMakeForm' => $form,
	    	'lang' => $lang,
	    );
	}
	
	public function addCarModelAction()
	{
		$this->layout('layout/admin-layout');
		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getCarModelForm();
	    
	    $carModel = new CarModel();
	    $form->bind($carModel);
	    $url = $this->url()->fromRoute(static::ROUTE_ADD_MODEL, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'carModelForm' => $form,
		    	'lang' => $lang,
		    );
        }
        $post = $prg; 	    
        $form->setData($post);
        if ($form->isValid()) {	        	
     		$om->persist($carModel);
            $om->flush();
            return array(
				'status' => true,
		    	'carModelForm' => $form,
		    	'lang' => $lang,
		    );
        }
	    return array(
	    	'carModelForm' => $form,
	    	'lang' => $lang,
	    );
	}
	
	public function addCarDriverAction()
	{
		$this->layout('layout/admin-layout');
		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getCarDriverForm();
	    
	    $carDriver = new CarDriver();
	    $form->bind($carDriver);
	    $url = $this->url()->fromRoute(static::ROUTE_ADD_DRIVER, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'carDriverForm' => $form,
		    	'lang' => $lang,
		    );
        }
        $post = $prg; 	    
        $form->setData($post);
        if ($form->isValid()) {	        	
     		$om->persist($carDriver);
            $om->flush();
            return array(
				'status' => true,
		    	'carDriverForm' => $form,
		    	'lang' => $lang,
		    );
        }
	    
	    return array(
	    	'carDriverForm' => $form,
	    	'lang' => $lang,
	    );
	}
	
	public function addCarAction()
	{
		$this->layout('layout/admin-layout');
		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getCarForm();
	    
		$makeId = $this->params()->fromQuery('makeId', null);
	    if ($makeId != null) {
	    	$models = $om->getRepository('Godana\Entity\CarModel')->findModelsByMakeId($makeId);
	    	$result = array();
	    	foreach ($models as $model) {
	    		$res = array('id' => $model->getId(), 'text' => strtoupper($model->getName()));
	    		array_push($result, $res);
	    	}
           	return new \Zend\View\Model\JsonModel($result);
	    }
	    
	    $car = new Car();
	    $form->bind($car);
	    $url = $this->url()->fromRoute(static::ROUTE_ADD_CAR, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'carForm' => $form,
		    	'lang' => $lang,
		    );
        }
        $post = $prg; 	    
        $form->setData($post);	    
        if ($form->isValid()) {	        	
     		$om->persist($car);
            $om->flush();
            return array(
				'status' => true,
		    	'carForm' => $form,
		    	'lang' => $lang,
		    );
        }
	    
	    return array(
	    	'carForm' => $form,
	    	'lang' => $lang,
	    );
	}
	
	public function addCarLineAction()
	{
		$this->layout('layout/admin-layout');
		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getLineCarForm();
	    
	    
	    $lineCar = new LineCar();
	    $form->bind($lineCar);
	    $url = $this->url()->fromRoute(static::ROUTE_ADD_LINE_CAR, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'lineCarForm' => $form,
		    	'lang' => $lang,
		    );
        }
        $post = $prg; 	    
        $form->setData($post);  
        if ($form->isValid()) { 	
     		$om->persist($lineCar);
            $om->flush();
            return array(
				'status' => true,
		    	'lineCarForm' => $form,
		    	'lang' => $lang,
		    );
        }
	    
	    return array(
	    	'lineCarForm' => $form,
	    	'lang' => $lang,
	    );
	}
	
	public function createReservationBoardAction()
	{
		$this->layout('layout/admin-layout');
		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getReservationBoardForm();
	    
	    
	    $reservationBoard = new ReservationBoard();
	    $form->bind($reservationBoard);
	    
        $url = $this->url()->fromRoute(static::ROUTE_CREATE_RESERVATION_BORD, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'reservationBoardForm' => $form,
		    	'lang' => $lang,
		    );
        }
        $post = $prg;
           
        $form->setData($post);
        if ($form->isValid()) { 
			$departureTime = $post['reservation-board-form']['departureTime'];
        	$reservationBoard->setDepartureTime(new \DateTime($departureTime));	
     		$om->persist($reservationBoard);
            $om->flush();
            return array(
				'status' => true,
		    	'reservationBoardForm' => $form,
		    	'lang' => $lang,
		    );
        }
        return array(
	    	'reservationBoardForm' => $form,
	    	'lang' => $lang,
	    );
	}
	
	public function createReservationAction()
	{
		$this->layout('layout/admin-layout');
		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getReservationForm();
	    
	    
	    $reservation = new Reservation();
	    $form->bind($reservation);
	    
        $url = $this->url()->fromRoute(static::ROUTE_CREATE_RESERVATION, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'reservationForm' => $form,
		    	'lang' => $lang,
		    );
        }
        $post = $prg;
        $form->setData($post);
        if ($form->isValid()) { 
			$om->persist($reservation);
			$om->flush();
            return array(
				'status' => true,
		    	'reservationForm' => $this->getReservationForm(),
		    	'lang' => $lang,
		    );
        }
        return array(
	    	'reservationForm' => $form,
	    	'lang' => $lang,
	    );
	}
	
	public function ajaxCarLineAction()
	{
		$om = $this->getObjectManager();
		$cooperativeId = $this->params()->fromQuery('cooperativeId', null); 		
	    $zoneId = $this->params()->fromQuery('zoneId', null);
	    $lineId = $this->params()->fromQuery('lineId', null);
	    
	    if ($cooperativeId != null) {
		    if ($zoneId != null) {
	    		$lines = $om->getRepository('Godana\Entity\Line')->findLinesByZoneAndCooperative($zoneId, $cooperativeId);
		    	$result = array();
		    	foreach ($lines as $line) {
		    		$departure = $line->getDeparture()->getCityAccented();
		    		$arrival = $line->getArrival()->getCityAccented();
		    		$lineValue = $departure . ' ==> ' . $arrival;
		    		$res = array('id' => $line->getId(), 'text' => $lineValue);			    		
		    		array_push($result, $res);
		    	}
	           	return new \Zend\View\Model\JsonModel($result);    		
	    	} else if ($lineId != null) {
	    		$cars = $om->getRepository('Godana\Entity\Line')->findCooperativeCarsNotInLine($lineId, $cooperativeId);
	    		$result = array();
	    		foreach ($cars as $car) {
	    			$res = array('id' => $car->getId(), 'text' => $car->getLicense());
	    			array_push($result, $res);
		    	}
	           	return new \Zend\View\Model\JsonModel($result);
	    	} else {
	    		$cooperative = $om->getRepository('Godana\Entity\Cooperative')->find($cooperativeId);
	    		$zones = $cooperative->getZones();
	    		$cars = $cooperative->getCars();
	    		$lines = $cooperative->getLines();
		    	$result = array();
		    	$result['zone'] = array();
		    	$result['car'] = array();
		    	$result['line'] = array();
		    	foreach ($zones as $zone) {
		    		$res = array('id' => $zone->getId(), 'text' => $zone->getName());
		    		array_push($result['zone'], $res);
		    	}
	    		foreach ($cars as $car) {
		    		$res = array('id' => $car->getId(), 'text' => $car->getLicense());
		    		array_push($result['car'], $res);
		    	}
		    	foreach ($lines as $line) {
		    		$departure = $line->getDeparture()->getCityAccented();
		    		$arrival = $line->getArrival()->getCityAccented();
		    		$lineValue = $departure . ' ==> ' . $arrival;
		    		$res = array('id' => $line->getId(), 'text' => $lineValue);			    		
		    		array_push($result['line'], $res);
		    	}
	           	return new \Zend\View\Model\JsonModel($result);	 
	    	}
	    	   	
	    } else {
	    	return new \Zend\View\Model\JsonModel(array());
	    }
	    
	}
	
	public function ajaxCarReservationAction()
	{
		$om = $this->getObjectManager();
		$cooperativeId = $this->params()->fromQuery('cooperativeId', null); 		
	    $zoneId = $this->params()->fromQuery('zoneId', null);
	    $lineId = $this->params()->fromQuery('lineId', null);
	    $departureTime = $this->params()->fromQuery('departureTime', null);
	    
	    if ($cooperativeId != null) {
		    if ($lineId != null && $departureTime != null) { 
	    		$departureTime = substr($departureTime, 0, 10);	    		
	    		$depTime = date('Y-m-d h:i a', (int)$departureTime);
	    		$dt = new \DateTime($depTime);
	    		$cars = $om->getRepository('Godana\Entity\ReservationBoard')->getAvailableCars($dt, $lineId, $cooperativeId);
	    		$result = array();
	    		foreach ($cars as $car) {
	    			$res = array('id' => $car->getId(), 'text' => $car->getLicense());			    		
		    		array_push($result, $res);
	    		}
	    	} else if ($zoneId != null) {
	    		$lines = $om->getRepository('Godana\Entity\Line')->findLinesByZoneAndCooperative($zoneId, $cooperativeId);
		    	$result = array();
		    	foreach ($lines as $line) {
		    		$departure = $line->getDeparture()->getCityAccented();
		    		$arrival = $line->getArrival()->getCityAccented();
		    		$lineValue = $departure . ' ==> ' . $arrival;
		    		$res = array('id' => $line->getId(), 'text' => $lineValue);			    		
		    		array_push($result, $res);
		    	}
	           	return new \Zend\View\Model\JsonModel($result);   		
	    	} else {
		    	$cooperative = $om->getRepository('Godana\Entity\Cooperative')->find($cooperativeId);
	    		$zones = $cooperative->getZones();
	    		$cars = $cooperative->getCars();
	    		$lines = $cooperative->getLines();
		    	$result = array();
		    	$result['zone'] = array();
		    	$result['car'] = array();
		    	$result['line'] = array();
		    	foreach ($zones as $zone) {
		    		$res = array('id' => $zone->getId(), 'text' => $zone->getName());
		    		array_push($result['zone'], $res);
		    	}
	    		foreach ($cars as $car) {
		    		$res = array('id' => $car->getId(), 'text' => $car->getLicense());
		    		array_push($result['car'], $res);
		    	}
		    	foreach ($lines as $line) {
		    		$departure = $line->getDeparture()->getCityAccented();
		    		$arrival = $line->getArrival()->getCityAccented();
		    		$lineValue = $departure . ' ==> ' . $arrival;
		    		$res = array('id' => $line->getId(), 'text' => $lineValue);			    		
		    		array_push($result['line'], $res);
		    	}
	    	}
	    	
           	return new \Zend\View\Model\JsonModel($result);	    	
	    }
	    
	}
	
	public function ajaxReservationAction()
	{
		$om = $this->getObjectManager();
			
	    $zoneId = $this->params()->fromQuery('zoneId', null);
	    $lineId = $this->params()->fromQuery('lineId', null);
	    $cooperativeId = $this->params()->fromQuery('cooperativeId', null); 	
	    $carId = $this->params()->fromQuery('carId', null);
	    $reservationBoardId = $this->params()->fromQuery('reservationBoardId', null);
	    $type = $this->params()->fromQuery('type', null);
	    
		if ($zoneId != null) {
    		$zone = $om->getRepository('Godana\Entity\Zone')->find($zoneId);	    		
    		$lines = $zone->getLines();
	    	$result = array();
	    	foreach ($lines as $line) {
	    		$departure = $line->getDeparture()->getCityAccented();
	    		$arrival = $line->getArrival()->getCityAccented();
	    		$lineValue = $departure . ' ==> ' . $arrival;
	    		$res = array('id' => $line->getId(), 'text' => $lineValue);			    		
	    		array_push($result, $res);
	    	}
           	return new \Zend\View\Model\JsonModel($result);    		
    	}
		if ($lineId != null) {
			$result = array();
			if ($cooperativeId != null) {
				$resBoards = $om->getRepository('Godana\Entity\ReservationBoard')
					->getReservationBoardByLineAndCooperativeFromNow($lineId, $cooperativeId);
				foreach ($resBoards as $resBoard) {
		    		$departure = $resBoard->getDepartureTime();
		    		$res = array('id' => $resBoard->getId(), 'text' => date_format($departure, 'jS, F Y H:i'));					
		    		array_push($result, $res);
		    	}
			} else {
				$line = $om->getRepository('Godana\Entity\Line')->find($lineId);
				$coops = $line->getCooperatives();
				foreach ($coops as $cooperative) {
					$res = array('id' => $cooperative->getId(), 'text' => $cooperative->getName());
					array_push($result, $res);
				}
			}
    		
           	return new \Zend\View\Model\JsonModel($result);    		
    	}
    	if ($reservationBoardId != null) {
    		$resBoard = $om->getRepository('Godana\Entity\ReservationBoard')->find($reservationBoardId);
    		$car = $resBoard->getCar();
    		$reservations = $resBoard->getReservations();
    		$line = $resBoard->getLine();
    		$lineCar = $om->getRepository('Godana\Entity\LineCar')->findOneBy(array('line' => $line->getId(), 'car' => $car->getId()));    		
    		$seats = $lineCar->getSeats();
    		$reservedSeats = array();
    		$availableSeats = array();
    		$result = array();
    		$result['car'] = array();
    		$result['seat'] = array();
    		$result['fare'] = array();
    		$res = array('id' => $car->getId(), 'text' => $car->getLicense());
    		array_push($result['car'], $res);
    		if (isset($reservations) && count($reservations) > 0) {
    			foreach ($reservations as $reservation) {
    				array_push($reservedSeats, $reservation->getSeat());
    			}
    		}
    		for ($i = 0; $i < $seats; $i++) {    			
    			$seatNumber = $i + 1;
    			if  (!in_array($seatNumber, $reservedSeats)) {
    				$availableSeats[$i] = $seatNumber;	
    			} else {
    				$seats--;
    			}    			
    		}
    		foreach ($availableSeats as $availableSeat) {
    			$res = array('id' => $availableSeat, 'text' => (string)$availableSeat);
    			array_push($result['seat'], $res);
    		}    		
			$fare = $lineCar->getFare();
    		array_push($result['fare'], $fare);
    		return new \Zend\View\Model\JsonModel($result);
    	}
    	if ($type != null) {
    		if ($type == 'departure') {
		    	$result = array();
	           	return new \Zend\View\Model\JsonModel($result);
    		} else if ($type == 'cooperative') {
		    	$result = array();		    	
	           	return new \Zend\View\Model\JsonModel($result);
    		} else if ($type == 'car') {
		    	$result = array();
	           	return new \Zend\View\Model\JsonModel($result);
    		} else if ($type == 'seat') {
		    	$result = array();		    	
	           	return new \Zend\View\Model\JsonModel($result);
    		}
    	}
	}
	
	public function listLineAction()
	{
		$om = $this->getObjectManager(); 		
	    $zoneId = $this->params()->fromQuery('zoneId', null);
	    
	    $ownerId = $this->zfcUserAuthentication()->getIdentity()->getId();
	    $lineProxy = $form->get('product-form')->get('shop')->getProxy();
		$shopProxy->setIsMethod(true)
        	->setFindMethod(array(
                'name'   => 'findShopByOwnerId',
                'params' => array('ownerId' => $ownerId),
           ));
 		return $this->getResponse();
	}
	
	public function getZoneForm()
    {
        if (!$this->zoneForm) {
            $this->setZoneForm($this->getServiceLocator()->get('zone_form'));
        }
        return $this->zoneForm;
    }

    public function setZoneForm(Form $zoneForm)
    {
        $this->zoneForm = $zoneForm;
    }

	public function getLineForm()
    {
        if (!$this->lineForm) {
            $this->setLineForm($this->getServiceLocator()->get('create_line_form'));
        }
        return $this->lineForm;
    }

    public function setLineForm(Form $lineForm)
    {
        $this->lineForm = $lineForm;
    }
    
	public function getCooperativeForm()
    {
        if (!$this->cooperativeForm) {
            $this->setCooperativeForm($this->getServiceLocator()->get('cooperative_form'));
        }
        return $this->cooperativeForm;
    }

    public function setCooperativeForm(Form $cooperativeForm)
    {
        $this->cooperativeForm = $cooperativeForm;
    }
    
	public function getCooperativeLineForm()
    {
        if (!$this->cooperativeLineForm) {
            $this->setCooperativeLineForm($this->getServiceLocator()->get('add_line_form'));
        }
        return $this->cooperativeLineForm;
    }

    public function setCooperativeLineForm(Form $cooperativeLineForm)
    {
        $this->cooperativeLineForm = $cooperativeLineForm;
    }
    
	public function getCarMakeForm()
    {
        if (!$this->carMakeForm) {
            $this->setCarMakeForm($this->getServiceLocator()->get('add_car_make_form'));
        }
        return $this->carMakeForm;
    }

    public function setCarMakeForm(Form $carMakeForm)
    {
        $this->carMakeForm = $carMakeForm;
    }
    
	public function getCarModelForm()
    {
        if (!$this->carModelForm) {
            $this->setCarModelForm($this->getServiceLocator()->get('add_car_model_form'));
        }
        return $this->carModelForm;
    }

    public function setCarModelForm(Form $carModelForm)
    {
        $this->carModelForm = $carModelForm;
    }
    
	public function getCarDriverForm()
    {
        if (!$this->carDriverForm) {
            $this->setCarDriverForm($this->getServiceLocator()->get('add_car_driver_form'));
        }
        return $this->carDriverForm;
    }

    public function setCarDriverForm(Form $carDriverForm)
    {
        $this->carDriverForm = $carDriverForm;
    }
    
	public function getCarForm()
    {
        if (!$this->carForm) {
            $this->setCarForm($this->getServiceLocator()->get('add_car_form'));
        }
        return $this->carForm;
    }

    public function setCarForm(Form $carForm)
    {
        $this->carForm = $carForm;
    }
    
	public function getLineCarForm()
    {
        if (!$this->lineCarForm) {
            $this->setLineCarForm($this->getServiceLocator()->get('add_line_car_form'));
        }
        return $this->lineCarForm;
    }

    public function setLineCarForm(Form $lineCarForm)
    {
        $this->lineCarForm = $lineCarForm;
    }
    
	public function getReservationBoardForm()
    {
        if (!$this->reservationBoardForm) {
            $this->setReservationBoardForm($this->getServiceLocator()->get('reservation_board_form'));
        }
        return $this->reservationBoardForm;
    }

    public function setReservationBoardForm(Form $reservationBoardForm)
    {
        $this->reservationBoardForm = $reservationBoardForm;
    }
    
	public function getReservationForm()
    {
        if (!$this->reservationForm) {
            $this->setReservationForm($this->getServiceLocator()->get('create_reservation_form'));
        }
        return $this->reservationForm;
    }

    public function setReservationForm(Form $reservationForm)
    {
        $this->reservationForm = $reservationForm;
    }

	public function getObjectManager()
    {
    	return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
    
    public function setObjectManager($objectManager)
    {
    	$this->objectManager = $objectManager;
    }
}