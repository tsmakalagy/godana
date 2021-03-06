<?php

namespace DoctrineORMModule\Proxy\__CG__\Godana\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Cooperative extends \Godana\Entity\Cooperative implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'id', 'name', 'zones', 'lines', 'contacts', 'lineContacts', 'cars', 'drivers', 'admins', 'tellers');
        }

        return array('__isInitialized__', 'id', 'name', 'zones', 'lines', 'contacts', 'lineContacts', 'cars', 'drivers', 'admins', 'tellers');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Cooperative $proxy) {
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
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', array($name));

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function addZones(\Doctrine\Common\Collections\ArrayCollection $zones)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addZones', array($zones));

        return parent::addZones($zones);
    }

    /**
     * {@inheritDoc}
     */
    public function removeZones(\Doctrine\Common\Collections\ArrayCollection $zones)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeZones', array($zones));

        return parent::removeZones($zones);
    }

    /**
     * {@inheritDoc}
     */
    public function getZones()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getZones', array());

        return parent::getZones();
    }

    /**
     * {@inheritDoc}
     */
    public function addZone(\Godana\Entity\Zone $zone)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addZone', array($zone));

        return parent::addZone($zone);
    }

    /**
     * {@inheritDoc}
     */
    public function addLines(\Doctrine\Common\Collections\ArrayCollection $lines)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addLines', array($lines));

        return parent::addLines($lines);
    }

    /**
     * {@inheritDoc}
     */
    public function removeLines(\Doctrine\Common\Collections\ArrayCollection $lines)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeLines', array($lines));

        return parent::removeLines($lines);
    }

    /**
     * {@inheritDoc}
     */
    public function getLines()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLines', array());

        return parent::getLines();
    }

    /**
     * {@inheritDoc}
     */
    public function addLine(\Godana\Entity\Line $line)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addLine', array($line));

        return parent::addLine($line);
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
    public function addLineContacts(\Doctrine\Common\Collections\ArrayCollection $lineContacts)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addLineContacts', array($lineContacts));

        return parent::addLineContacts($lineContacts);
    }

    /**
     * {@inheritDoc}
     */
    public function removeLineContacts(\Doctrine\Common\Collections\ArrayCollection $lineContacts)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeLineContacts', array($lineContacts));

        return parent::removeLineContacts($lineContacts);
    }

    /**
     * {@inheritDoc}
     */
    public function getLineContacts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLineContacts', array());

        return parent::getLineContacts();
    }

    /**
     * {@inheritDoc}
     */
    public function addLineContact(\Godana\Entity\LineContact $lineContact)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addLineContact', array($lineContact));

        return parent::addLineContact($lineContact);
    }

    /**
     * {@inheritDoc}
     */
    public function addCars(\Doctrine\Common\Collections\ArrayCollection $cars)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCars', array($cars));

        return parent::addCars($cars);
    }

    /**
     * {@inheritDoc}
     */
    public function removeCars(\Doctrine\Common\Collections\ArrayCollection $cars)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeCars', array($cars));

        return parent::removeCars($cars);
    }

    /**
     * {@inheritDoc}
     */
    public function getCars()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCars', array());

        return parent::getCars();
    }

    /**
     * {@inheritDoc}
     */
    public function addCar($car)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCar', array($car));

        return parent::addCar($car);
    }

    /**
     * {@inheritDoc}
     */
    public function addDrivers(\Doctrine\Common\Collections\ArrayCollection $drivers)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addDrivers', array($drivers));

        return parent::addDrivers($drivers);
    }

    /**
     * {@inheritDoc}
     */
    public function removeDrivers(\Doctrine\Common\Collections\ArrayCollection $drivers)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeDrivers', array($drivers));

        return parent::removeDrivers($drivers);
    }

    /**
     * {@inheritDoc}
     */
    public function getDrivers()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDrivers', array());

        return parent::getDrivers();
    }

    /**
     * {@inheritDoc}
     */
    public function addDriver($driver)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addDriver', array($driver));

        return parent::addDriver($driver);
    }

    /**
     * {@inheritDoc}
     */
    public function addAdmins(\Doctrine\Common\Collections\ArrayCollection $admins)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addAdmins', array($admins));

        return parent::addAdmins($admins);
    }

    /**
     * {@inheritDoc}
     */
    public function removeAdmins(\Doctrine\Common\Collections\ArrayCollection $admins)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeAdmins', array($admins));

        return parent::removeAdmins($admins);
    }

    /**
     * {@inheritDoc}
     */
    public function removeAllAdmins()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeAllAdmins', array());

        return parent::removeAllAdmins();
    }

    /**
     * {@inheritDoc}
     */
    public function getAdmins()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAdmins', array());

        return parent::getAdmins();
    }

    /**
     * {@inheritDoc}
     */
    public function addAdmin($admin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addAdmin', array($admin));

        return parent::addAdmin($admin);
    }

    /**
     * {@inheritDoc}
     */
    public function addTellers(\Doctrine\Common\Collections\ArrayCollection $tellers)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addTellers', array($tellers));

        return parent::addTellers($tellers);
    }

    /**
     * {@inheritDoc}
     */
    public function removeTellers(\Doctrine\Common\Collections\ArrayCollection $tellers)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeTellers', array($tellers));

        return parent::removeTellers($tellers);
    }

    /**
     * {@inheritDoc}
     */
    public function removeAllTellers()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeAllTellers', array());

        return parent::removeAllTellers();
    }

    /**
     * {@inheritDoc}
     */
    public function getTellers()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTellers', array());

        return parent::getTellers();
    }

    /**
     * {@inheritDoc}
     */
    public function addTeller($teller)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addTeller', array($teller));

        return parent::addTeller($teller);
    }

    /**
     * {@inheritDoc}
     */
    public function hasUser($user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasUser', array($user));

        return parent::hasUser($user);
    }

}
