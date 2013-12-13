<?php

namespace DoctrineORMModule\Proxy\__CG__\Godana\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Post extends \Godana\Entity\Post implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'title', 'ident', 'detail', 'published', 'modified', 'deleted', 'categories', 'contacts', 'files');
        }

        return array('__isInitialized__', 'id', 'title', 'ident', 'detail', 'published', 'modified', 'deleted', 'categories', 'contacts', 'files');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Post $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', array($id));

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTitle', array());

        return parent::getTitle();
    }

    /**
     * {@inheritDoc}
     */
    public function setTitle($title)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTitle', array($title));

        return parent::setTitle($title);
    }

    /**
     * {@inheritDoc}
     */
    public function getIdent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdent', array());

        return parent::getIdent();
    }

    /**
     * {@inheritDoc}
     */
    public function setIdent($ident)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdent', array($ident));

        return parent::setIdent($ident);
    }

    /**
     * {@inheritDoc}
     */
    public function getDetail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDetail', array());

        return parent::getDetail();
    }

    /**
     * {@inheritDoc}
     */
    public function setDetail($detail)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDetail', array($detail));

        return parent::setDetail($detail);
    }

    /**
     * {@inheritDoc}
     */
    public function getPublished()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPublished', array());

        return parent::getPublished();
    }

    /**
     * {@inheritDoc}
     */
    public function setPublished($published)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPublished', array($published));

        return parent::setPublished($published);
    }

    /**
     * {@inheritDoc}
     */
    public function getModified()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModified', array());

        return parent::getModified();
    }

    /**
     * {@inheritDoc}
     */
    public function setModified($modified)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModified', array($modified));

        return parent::setModified($modified);
    }

    /**
     * {@inheritDoc}
     */
    public function getDeleted()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDeleted', array());

        return parent::getDeleted();
    }

    /**
     * {@inheritDoc}
     */
    public function setDeleted($deleted)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDeleted', array($deleted));

        return parent::setDeleted($deleted);
    }

    /**
     * {@inheritDoc}
     */
    public function getCategories()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCategories', array());

        return parent::getCategories();
    }

    /**
     * {@inheritDoc}
     */
    public function addCategory($category)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCategory', array($category));

        return parent::addCategory($category);
    }

    /**
     * {@inheritDoc}
     */
    public function addCategories(\Doctrine\Common\Collections\ArrayCollection $categories)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCategories', array($categories));

        return parent::addCategories($categories);
    }

    /**
     * {@inheritDoc}
     */
    public function removeCategories(\Doctrine\Common\Collections\ArrayCollection $categories)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeCategories', array($categories));

        return parent::removeCategories($categories);
    }

    /**
     * {@inheritDoc}
     */
    public function addContacts(\Doctrine\Common\Collections\ArrayCollection $contacts)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addContacts', array($contacts));

        return parent::addContacts($contacts);
    }

    /**
     * {@inheritDoc}
     */
    public function removeContacts(\Doctrine\Common\Collections\ArrayCollection $contacts)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeContacts', array($contacts));

        return parent::removeContacts($contacts);
    }

    /**
     * {@inheritDoc}
     */
    public function getContacts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContacts', array());

        return parent::getContacts();
    }

    /**
     * {@inheritDoc}
     */
    public function addContact($contact)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addContact', array($contact));

        return parent::addContact($contact);
    }

    /**
     * {@inheritDoc}
     */
    public function getFiles()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFiles', array());

        return parent::getFiles();
    }

    /**
     * {@inheritDoc}
     */
    public function addFile($file)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addFile', array($file));

        return parent::addFile($file);
    }

    /**
     * {@inheritDoc}
     */
    public function addFiles(\Doctrine\Common\Collections\ArrayCollection $files)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addFiles', array($files));

        return parent::addFiles($files);
    }

    /**
     * {@inheritDoc}
     */
    public function removeFiles(\Doctrine\Common\Collections\ArrayCollection $files)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeFiles', array($files));

        return parent::removeFiles($files);
    }

    /**
     * {@inheritDoc}
     */
    public function setOptions($options = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOptions', array($options));

        return parent::setOptions($options);
    }

}