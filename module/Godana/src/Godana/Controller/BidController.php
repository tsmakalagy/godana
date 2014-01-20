<?php
namespace Godana\Controller;
 
use ZendSearch\Lucene\Document\Field;

use Zend\Form\Form;
use Godana\Entity\Post;
use Godana\Entity\Bid;
use Godana\Entity\File;
use Godana\Form\PostForm;
use JqueryFileUpload\Handler\CustomUploadHandler;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Http\PhpEnvironment\Response as Response;

use ZendSearch\Lucene\Lucene;
use ZendSearch\Lucene\Document;

 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Json\Json;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class BidController extends AbstractActionController
{
	const ROUTE_ADD_BID = 'add-bid';
	
	/**
     * @var Form
     */
    protected $bidForm;
    
    /**
     * @var Form
     */
    protected $fileForm;
    
    /**
     * @var ObjectManager
     */
    protected $objectManager;
    
        
	public function indexAction()
	{	
		$lang = $this->params()->fromRoute('lang', 'mg');
		$om = $this->getObjectManager();
		
		$typeBid = $this->params()->fromRoute('type', null);
		$categoryIdent = $this->params()->fromRoute('categoryIdent', null);
		if ($typeBid == null) {
			$query = $om->getRepository('Godana\Entity\Bid')->getBids(0);	
		} else if ($typeBid == 'offer') {
			if ($categoryIdent == null) {
				$query = $om->getRepository('Godana\Entity\Bid')->getBidsByType(0);	
			} else {
				$query = $om->getRepository('Godana\Entity\Bid')->getBidsByTypeAndCategoryIdent(0, $categoryIdent);
			}			
		} else if ($typeBid == 'demand') {
			if ($categoryIdent == null) {
				$query = $om->getRepository('Godana\Entity\Bid')->getBidsByType(1);	
			} else {
				$query = $om->getRepository('Godana\Entity\Bid')->getBidsByTypeAndCategoryIdent(1, $categoryIdent);
			}			
		}
		$page = $this->params()->fromRoute('page', 1);
		$adapter = new DoctrineAdapter(new ORMPaginator($query));
   		
		$paginator = new Paginator($adapter);
   		$paginator->setDefaultItemCountPerPage(6);
		$paginator->setCurrentPageNumber($page);
				
 		return new ViewModel(
 			array(
 				'paginator' => $paginator,
 				'lang' => $lang,
 				'typeBid' => $typeBid,
 				'categoryIdent' => $categoryIdent
 			)
 		);
 	}
 	
 	public function detailAction()
 	{
// 		$markers = array(
//	        'Mozzat Web Team' => '-18.7166667,46.2166667'
//	    );  //markers location with latitude and longitude
//	
//	    $config = array(
//	        'sensor' => 'true',         //true or false
//	        'div_id' => 'map',          //div id of the google map
//	        'div_class' => 'grid_6',    //div class of the google map
//	        'zoom' => 5,                //zoom level
//	        'width' => "600px",         //width of the div
//	        'height' => "300px",        //height of the div
//	        'lat' => -18.7166667,         //lattitude
//	        'lon' => 46.2166667,         //longitude 
//	        'animation' => 'none',      //animation of the marker
//	        'markers' => $markers       //loading the array of markers
//	    );
//	
//	    $map = $this->getServiceLocator()->get('GMaps\Service\GoogleMap'); //getting the google map object using service manager
//	    $map->initialize($config);                                         //loading the config   
//	    $html = $map->generate();                                          //genrating the html map content  
    
// 		$index = Lucene::open("/tmp/ttt");
// 		$query = 'zezika';
// 		$hits = $index->find($query);
// 		echo "Search for '".$query."' returned " .count($hits). " hits\n\n";
//	 	foreach ($hits as $hit) {
//			echo $hit->title."\n";			
//			echo "\t".$hit->link."\n\n";
//		}
 		
 		$om = $this->getObjectManager();
 		$postIdent = $this->params()->fromRoute('postIdent', null);
 		$lang = $this->params()->fromRoute('lang', 'mg');
 		if ($postIdent == null) {
 			return $this->redirect()->toRoute('bid');
 		}
 		
		$bid = $om->getRepository('Godana\Entity\Bid')->getBidByPostIdent($postIdent);
		if ($bid instanceof \Godana\Entity\Bid) {
			return new ViewModel(
	 			array(
	 				'bid' => $bid,
	 				'lang' => $lang,
//					'map_html' => $html
	 			)
	 		);
		}		
 		//return $this->redirect()->toRoute('bid');
 	}
 	
 	public function addAction()
 	{
 		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getBidForm();
	    $fileform = $this->getFileForm();
	
	    // Create a new, empty entity and bind it to the form
	    $bid = new Bid();
	    $form->bind($bid);
	
	    $url = $this->url()->fromRoute(static::ROUTE_ADD_BID, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'bidForm' => $form,
		    	'fileForm' => $fileform,
		    	'lang' => $lang,
		    );
        }
        $post = $prg;
        $form->setData($post);
		$listFileId = array();
		
        if ($form->isValid()) {
        	$post = $bid->getPost();	        	
        	$post->setIdent($this->slug()->seoUrl($post->getTitle()));
            
            $listFileId = $this->request->getPost()->get('file-id');
            if (count($listFileId) > 0) {
            	foreach ($listFileId as $fileId) {
            		$file = $om->find('Godana\Entity\File', (int)$fileId);
            		if ($file instanceof File) {
            			$post->addFile($file);
            			$om->persist($post);
            		}	            		
            	}
            	$om->flush();
            } else {
            	$om->persist($post);
            	$om->flush();
            }
            $user = $this->zfcUserAuthentication()->getIdentity();
            $bid->setUser($user);	            
            $om->persist($bid);
            $om->flush();
            return $this->redirect()->toRoute('bid');
        }
	        
	    
		
	    return array(
	    	'bidForm' => $form,
	    	'fileForm' => $fileform,
	    	'lang' => $lang,
	    ); 		
 	}
 	
 	public function cityAction()
 	{
 		$om = $this->getObjectManager();
 		$tag = $this->params()->fromQuery('tag', null);
 		$cities = $om->getRepository('Godana\Entity\City')->getCountryCitiesStartingBy($tag);
 		$result = array();
		foreach($cities AS $city) {
			$res = array(
				'id' => $city->getId(),
				'value' => $city->getCityAccented()
			);
			array_push($result, $res);
		}
 		return new \Zend\View\Model\JsonModel($result);
 	}
 	
 	public function ajaxAction()
 	{ 		
        $uploadhandler = $this->getServiceLocator()->get('upload_handler');        
        return $this->getResponse();
        
 	}
 	
 	public function uploadAction()
 	{
 		$form = $this->getFileForm();
 		$data = array_merge_recursive(
        	$this->getRequest()->getPost()->toArray(),
            $this->getRequest()->getFiles()->toArray()
        );

		$form->setData($data);
        if ($form->isValid()) {
        	//return new \Zend\View\Model\JsonModel($form->getData());
        	new UploadHandler();
        }
        return array('form' => $form);

 		
 	}
 	
 	public function mediaAction()
 	{
 		if ($this->request->isPost()) {
 			new UploadHandler();
 		}
 		$view = new ViewModel();
 		$view->setTemplate('godana/bid/single');
 		return $view;
 	}
 	
 	public function editAction()
 	{
 		$form = $this->getBidForm();
 		return array(
	    	'bidForm' => $form,
	    ); 	
 	}
 	
	public function getBidForm()
    {
        if (!$this->bidForm) {
            $this->setBidForm($this->getServiceLocator()->get('bid_form'));
        }
        return $this->bidForm;
    }

    public function setBidForm(Form $bidForm)
    {
        $this->bidForm = $bidForm;
    }
    
	public function getFileForm()
    {
        if (!$this->fileForm) {
            $this->setFileForm($this->getServiceLocator()->get('file_form'));
        }
        return $this->fileForm;
    }

    public function setFileForm(Form $fileForm)
    {
        $this->fileForm = $fileForm;
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