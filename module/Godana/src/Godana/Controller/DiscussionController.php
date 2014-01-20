<?php
namespace Godana\Controller;

use Zend\Form\Form;
use JqueryFileUpload\Handler\CustomUploadHandler;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Http\PhpEnvironment\Response as Response;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class DiscussionController extends AbstractActionController
{
	const ROUTE_CREATE_DISCUSSION = 'create-discussion';
	
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