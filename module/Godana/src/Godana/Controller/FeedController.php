<?php
namespace Godana\Controller;

use Godana\Entity\Feed;

use Godana\Entity\Tag;

use Godana\Entity\Post;

use Zend\Form\Form;
use JqueryFileUpload\Handler\CustomUploadHandler;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Http\PhpEnvironment\Response as Response;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class FeedController extends AbstractActionController
{
	const ROUTE_ADD_FEED = 'tools/feed/add';
	
	/**
     * @var Form
     */
    protected $feedForm;
    
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
    	$this->layout('layout/tools-layout');
    	$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $list = new \Zend\Tag\ItemList();
	    $list = array();
	    $feeds = $om->getRepository('Godana\Entity\Feed')->getAllFeeds();
	    $arrayOfTags = array();
	    foreach ($feeds as $feed) {
	    	$post = $feed->getPost();
	    	$tags = $post->getTags();
	    	foreach ($tags as $tag) {
	    		$tagTitle = $tag->getTitle();
	    		if (array_key_exists($tagTitle, $arrayOfTags)) {
	    			$arrayOfTags[$tagTitle] += 1;
	    		} else {
	    			$arrayOfTags[$tagTitle] = 1;	
	    		}	    		
	    	}
	    }
	    foreach ($arrayOfTags as $title => $count) {
//	    	$list[] = new \Zend\Tag\Item(array('title' => $title, 'weight' => $count,
//	    	 'params' => array('url' => '/tag/'.$title)));
	    	$list[] = array('title' => $title, 'weight' => $count,
	    	 'params' => array('url' => '/tag/'.$title));
	    }
	    $cloud = new \Zend\Tag\Cloud(array('tags' => $list));
//	    var_dump($cloud);
	    return array('lang' => $lang, 'feeds' => $feeds, 'cloud' => $cloud);
    }
    
	public function addAction()
 	{
 		$this->layout('layout/tools-layout');
 		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getFeedForm();
	    $fileform = $this->getFileForm();
	
	    // Create a new, empty entity and bind it to the form
	    $feed = new Feed();
	    $form->bind($feed);
	
	    $url = $this->url()->fromRoute(static::ROUTE_ADD_FEED, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'feedForm' => $form,
		    	'fileForm' => $fileform,
		    	'lang' => $lang,
		    );
        }
        $post = $prg;
        $form->setData($post);
		$listFileId = array();
        if ($form->isValid()) {   
        	$newpost = $feed->getPost(); 
        	$tags = split(',', $post['feed-form']['post']['tag']);
        	foreach ($tags as $tag) {
        		if (is_numeric($tag)) {
        			$t = $om->find('Godana\Entity\Tag', (int)$tag);        			
        		} else if (strlen($tag) > 0) {
        			$t = new Tag();
        			$t->setTitle(strtolower($tag));
        			$om->persist($t);
        		}
        		$newpost->addTag($t);
        	}
        	$newpost->setIdent($this->slug()->seoUrl($newpost->getTitle()));
            $user = $this->zfcUserAuthentication()->getIdentity();
            $newpost->setUser($user);
            $listFileId = $this->request->getPost()->get('file-id');
            if (count($listFileId) > 0) {
            	foreach ($listFileId as $fileId) {
            		$file = $om->find('Godana\Entity\File', (int)$fileId);
            		if ($file instanceof File) {
            			$newpost->addFile($file);
            			$om->persist($newpost);
            		}	            		
            	}
            	$om->flush();
            } else {
            	$om->persist($newpost);
            	$om->flush();
            }            
            $om->persist($feed);
            $om->flush();
            return $this->redirect()->toRoute('tools/feed', array('lang' => $lang), array(), true);
        }
	        
	    
		
	    return array(
	    	'feedForm' => $form,
	    	'fileForm' => $fileform,
	    	'lang' => $lang,
	    ); 		
 	}
 	
	public function uploadAjaxAction()
 	{ 		
        $uploadhandler = $this->getServiceLocator()->get('feed_upload_handler');  
        return $this->getResponse();        
 	}
 	
 	public function ajaxTagAction()
 	{
 		$om = $this->getObjectManager();
 		$tags = $om->getRepository('Godana\Entity\Tag')->findAll();
 		$result = array();
 		foreach ($tags as $tag) {
 			$res = array('id' => $tag->getId(), 'text' => $tag->getTitle());
 			array_push($result, $res);
 		}
 		return new \Zend\View\Model\JsonModel($result);
 	}
    
	public function getFeedForm()
    {
        if (!$this->feedForm) {
            $this->setFeedForm($this->getServiceLocator()->get('feed_form'));
        }
        return $this->feedForm;
    }

    public function setFeedForm(Form $feedForm)
    {
        $this->feedForm = $feedForm;
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