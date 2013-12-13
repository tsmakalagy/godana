<?php
namespace JqueryFileUpload\Handler;

use Godana\Entity\File;
use Doctrine\Common\Persistence\ObjectManager as ObjectManager;
use Zend\Authentication\AuthenticationService;

class CustomUploadHandler extends UploadHandler
{
	
	/**
     * @var AuthenticationService
     */
    protected $authService;
    
	protected $objectManager;
	
	public function __construct(ObjectManager $om, AuthenticationService $as, $options)
	{
		$this->objectManager = $om;
		$this->authService = $as;
		parent::__construct($options);
	}
	
	protected function get_user_id()
	{
		return $this->getAuthService()->getIdentity()->getId();
	}
	
	protected function handle_form_data($file, $index) {
    	$file->title = @$_REQUEST['title'][$index];
    	$file->description = @$_REQUEST['description'][$index];
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
            $index = null, $content_range = null) {
        $file = parent::handle_file_upload(
        	$uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        
        $om = $this->getObjectManager();
        if (empty($file->error)) {
        	$myfile = new File();
	        $myfile->setName($file->name);
	        $myfile->setSize($file->size);
	        $myfile->setType($file->type);
	        $myfile->setTitle($file->title);
	        $myfile->setUrl($file->url);
	        $myfile->setDescription($file->description);
	        
	        $om->persist($myfile);
	        $om->flush();
	        $file->id = $myfile->getId();
        }
        return $file;
    }

    protected function set_additional_file_properties($file) {        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        	$om = $this->getObjectManager();  
        	$myfile = $om->getRepository('Godana\Entity\File')->findOneByName($file->name);
        	if ($myfile instanceof \Godana\Entity\File) {
        		$file->id = $myfile->getId();
        		$file->type = $myfile->getType();
        		$file->title = $myfile->getTitle();
        		$file->url = $myfile->getUrl();
        		$file->description = $myfile->getDescription();
        	} 	
        }
        parent::set_additional_file_properties($file);
    }

    public function delete($print_response = true) {
        $response = parent::delete(false);
        foreach ($response as $name => $deleted) {
        	if ($deleted) {
        		$om = $this->getObjectManager();        	
        		$myfile = $om->getRepository('Godana\Entity\File')->findOneByName($name);
        		$om->remove($myfile);
        		$om->flush();
        	}
        } 
        return $this->generate_response($response, $print_response);
    }

	protected function trim_file_name($name, $type = null, $index = null, $content_range = null) 
	{
        $name = parent::trim_file_name($name, $type);
        // Your file name changes: $name = 'something';
        $ext = strrchr($name,".");
		$name = md5(uniqid(rand()));
		$name = substr($name,0,10);
		$name = $name . $ext;
        return $name;
    }
    
	public function getObjectManager()
    {
    	return $this->objectManager;
    }
    
    public function setObjectManager(ObjectManager $objectManager)
    {
    	$this->objectManager = $objectManager;
    }
    
	/**
     * Get authService.
     *
     * @return AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * Set authService.
     *
     * @param AuthenticationService $authService
     * @return \ZfcUser\View\Helper\ZfcUserIdentity
     */
    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        return $this;
    }
}