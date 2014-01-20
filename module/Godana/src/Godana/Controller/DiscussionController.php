<?php
namespace Godana\Controller;

use Godana\Entity\Tag;

use Godana\Entity\Post;

use Zend\Form\Form;
use JqueryFileUpload\Handler\CustomUploadHandler;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Http\PhpEnvironment\Response as Response;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class DiscussionController extends AbstractActionController
{
	const ROUTE_CREATE_DISCUSSION = 'tools/discussion/create';
	
	/**
     * @var Form
     */
    protected $discussionForm;
    
    /**
     * @var Form
     */
    protected $fileForm;
    
    /**
     * @var ObjectManager
     */
    protected $objectManager;
    
	public function createAction()
 	{
 		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getDiscussionForm();
	    $fileform = $this->getFileForm();
	
	    // Create a new, empty entity and bind it to the form
	    $newpost = new Post();
	    $form->bind($newpost);
	
	    $url = $this->url()->fromRoute(static::ROUTE_CREATE_DISCUSSION, array('lang' => $lang));
	    $prg = $this->prg($url, true);

        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'discussionForm' => $form,
		    	'fileForm' => $fileform,
		    	'lang' => $lang,
		    );
        }
        $post = $prg;
        $form->setData($post);
		$listFileId = array();
        if ($form->isValid()) {    
        	$tags = split(',', $post['post-form']['tag']);
        	foreach ($tags as $tag) {
        		if (is_numeric($tag)) {
        			$t = $om->find('Godana\Entity\Tag', (int)$tag);        			
        		} else if (strlen($tag) > 0) {
        			$t = new Tag();
        			$t->setTitle($tag);
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
            return array(
            	'status' => true,
		    	'discussionForm' => $form,
		    	'fileForm' => $fileform,
		    	'lang' => $lang,
		    );
        }
	        
	    
		
	    return array(
	    	'discussionForm' => $form,
	    	'fileForm' => $fileform,
	    	'lang' => $lang,
	    ); 		
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
    
	public function getDiscussionForm()
    {
        if (!$this->discussionForm) {
            $this->setDiscussionForm($this->getServiceLocator()->get('discussion_form'));
        }
        return $this->discussionForm;
    }

    public function setDiscussionForm(Form $discussionForm)
    {
        $this->discussionForm = $discussionForm;
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