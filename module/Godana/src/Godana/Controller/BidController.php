<?php
namespace Godana\Controller;
 
use ZendSearch\Lucene\Document\Field;

use Zend\Form\Form;
use Godana\Entity\Post;
use Godana\Entity\Bid;
use Godana\Entity\File;
use Godana\Form\PostForm;
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
    
    protected $uploadHandler;
    
        
	public function indexAction()
	{	
		$lang = $this->params()->fromRoute('lang', 'mg');
		$om = $this->getObjectManager();
		
		$form = $this->getBidForm();
	    $fileform = $this->getFileForm();
		
//		$typeBid = $this->params()->fromRoute('type', null);
//		$categoryIdent = $this->params()->fromRoute('categoryIdent', null);
//		if ($typeBid == null) {
//			$query = $om->getRepository('Godana\Entity\Bid')->getBids(0);	
//		} else if ($typeBid == 'offer') {
//			if ($categoryIdent == null) {
//				$query = $om->getRepository('Godana\Entity\Bid')->getBidsByType(0);	
//			} else {
//				$query = $om->getRepository('Godana\Entity\Bid')->getBidsByTypeAndCategoryIdent(0, $categoryIdent);
//			}			
//		} else if ($typeBid == 'demand') {
//			if ($categoryIdent == null) {
//				$query = $om->getRepository('Godana\Entity\Bid')->getBidsByType(1);	
//			} else {
//				$query = $om->getRepository('Godana\Entity\Bid')->getBidsByTypeAndCategoryIdent(1, $categoryIdent);
//			}			
//		}
//		$page = $this->params()->fromRoute('page', 1);
//		$adapter = new DoctrineAdapter(new ORMPaginator($query));
//   		
//		$paginator = new Paginator($adapter);
//   		$paginator->setDefaultItemCountPerPage(6);
//		$paginator->setCurrentPageNumber($page);
		$bids = $om->getRepository('Godana\Entity\Bid')->getAllBids();		
 		return new ViewModel(
 			array(
// 				'paginator' => $paginator,
 				'lang' => $lang,
// 				'typeBid' => $typeBid,
// 				'categoryIdent' => $categoryIdent,
				'bids' => $bids,
 				'bidForm' => $form,
		    	'fileForm' => $fileform,
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
            $user = $this->zfcUserAuthentication()->getIdentity();
            $post->setUser($user);
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
            $index = Lucene::open(DATA_PATH.'/search');
			$doc = new Document();	            
            $om->persist($bid);
            $om->flush();
            $title = $bid->getPost()->getTitle();
			$detail = $bid->getPost()->getDetail();
			$published = date_format($bid->getPost()->getPublished(), 'd M Y');
			$ident = $bid->getPost()->getIdent();
			$type = $bid->getType();
			if ($type == 0) {
				$typeBid = 'offer';
			} else if ($type == 1) {
				$typeBid = 'demand';
			}
			$link = $this->createDetailBidUrl($lang, $typeBid, $ident);
			
			$doc->addField(Document\Field::keyword('link', $link));
			$doc->addField(Document\Field::text('title', $title));
			$doc->addField(Document\Field::unIndexed('published', $published));
			$doc->addField(Document\Field::unIndexed('type', $type));
			$doc->addField(Document\Field::text('contents', $detail));
			$index->addDocument($doc);
			$index->commit();
            return $this->redirect()->toRoute('bid', array('lang' => $lang,
            'page' => null, 'type' => null, 'categoryIdent' => null), array(), true);
        }
	        
	    
		
	    return array(
	    	'bidForm' => $form,
	    	'fileForm' => $fileform,
	    	'lang' => $lang,
	    ); 		
 	} 	
 	
 	public function addAjaxAction()
 	{
 		$form    = $this->getBidForm();
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        $om = $this->getObjectManager(); 

        
        $bid = new Bid();
	    $form->bind($bid);	    
	    
        $messages = array();        
        if ($request->isPost()){
        	$post = $request->getPost();
            $form->setData($request->getPost());
            if ( ! $form->isValid()) {
                $bidFieldset = $form->get('bid-form');
            	$messages['type'] = array();            	
                $typeError = $bidFieldset->get('type')->getMessages();
                $i = 0;
                foreach ($typeError as $message) {
                	$messages['type'][$i++] = $message;
                }
                $messages['city'] = array(); 
            	$cityError = $bidFieldset->get('city')->getMessages();
                $i = 0;
                foreach ($cityError as $message) {
                	$messages['city'][$i++] = $message;
                }
                $messages['price'] = array(); 
            	$priceError = $bidFieldset->get('price')->getMessages();
                $i = 0;
                foreach ($priceError as $message) {
                	$messages['price'][$i++] = $message;
                }
                $postFieldset = $bidFieldset->get('post');
                $messages['post'] = array();
                
            	$messages['post']['categories'] = array(); 
            	$categoriesError = $postFieldset->get('categories')->getMessages();
                $i = 0;
                foreach ($categoriesError as $message) {
                	$messages['post']['categories'][$i++] = $message;
                }
            	$messages['post']['title'] = array(); 
            	$titleError = $postFieldset->get('title')->getMessages();
                $i = 0;
                foreach ($titleError as $message) {
                	$messages['post']['title'][$i++] = $message;
                }
                $contacts = $postFieldset->get('contacts');
                $messages['post']['contacts'] = array();
                foreach ($contacts as $key => $contact) {
					$messages['post']['contacts'][$key]['value'] = array();	
					$i = 0;
					$contactError = $contact->get('value')->getMessages();	
	                foreach ($contactError as $message) {
	                	$messages['post']['contacts'][$key]['value'][$i++] = $message;
	                }			                	
                }
				
            }             
            if (!empty($messages)){     
				$response->setContent(\Zend\Json\Json::encode($messages));
            } else {
            	$post = $bid->getPost();	        	
	        	$post->setIdent($this->slug()->seoUrl($post->getTitle()));
	            $user = $this->zfcUserAuthentication()->getIdentity();
	            $post->setUser($user);
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
	            $index = Lucene::open(DATA_PATH.'/search');
				$doc = new Document();	            
	            $om->persist($bid);
	            $om->flush();
	            $title = $bid->getPost()->getTitle();
				$detail = $bid->getPost()->getDetail();
				$published = date_format($bid->getPost()->getPublished(), 'd M Y');
				$ident = $bid->getPost()->getIdent();
				$type = $bid->getType();
				if ($type == 0) {
					$typeBid = 'offer';
				} else if ($type == 1) {
					$typeBid = 'demand';
				}
				$link = $this->createDetailBidUrl($lang, $typeBid, $ident);
				
				$doc->addField(Document\Field::keyword('link', $link));
				$doc->addField(Document\Field::text('title', $title));
				$doc->addField(Document\Field::unIndexed('published', $published));
				$doc->addField(Document\Field::unIndexed('type', $type));
				$doc->addField(Document\Field::text('contents', $detail));
				$index->addDocument($doc);
				$index->commit();
	            
		 		$item_feed = $this->createFeedDiv($feed, 'sm', 1);
		 		return new \Zend\View\Model\JsonModel(array('success' => true, 'item_feed' => $item_feed));	
            }
        }
         
        return $response;
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
 	
 	public function uploadAjaxAction()
 	{ 		
        $this->uploadhandler = $this->getServiceLocator()->get('bid_upload_handler');  
        return $this->getResponse();
        
 	}
 	
 	public function getUploadHandler()
 	{
 		return $this->uploadHandler;
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
    
	private function createDetailBidUrl($lang, $typeBid, $ident)
    {
    	return $this->url()->fromRoute('detail-bid', array(
    		'lang' => $lang,
    		'type' => $typeBid,
    		'postIdent' => $ident
    	));
    }
    
}