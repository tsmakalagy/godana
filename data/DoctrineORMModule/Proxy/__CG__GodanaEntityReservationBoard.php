<?php

namespace DoctrineORMModule\Proxy\__CG__\Godana\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class ReservationBoard extends \Godana\Entity\ReservationBoard implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'id', 'departureTime', 'car', 'reservations', 'line', 'cooperative');
        }

        return array('__isInitialized__', 'id', 'departureTime', 'car', 'reservations', 'line', 'cooperative');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (ReservationBoard $proxy) {
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
    public function getDepartureTime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDepartureTime', array());

        return parent::getDepartureTime();
    }

    /**
     * {@inheritDoc}
     */
    public function setDepartureTime($departureTime)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDepartureTime', array($departureTime));

        return parent::setDepartureTime($departureTime);
    }

    /**
     * {@inheritDoc}
     */
    public function getCar()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCar', array());

        return parent::getCar();
    }

    /**
     * {@inheritDoc}
     */
    public function setCar($Car)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCar', array($Car));

        return parent::setCar($Car);
    }

    /**
     * {@inheritDoc}
     */
    public function addReservations(\Doctrine\Common\Collections\ArrayCollection $reservations)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addReservations', array($reservations));

        return parent::addReservations($reservations);
    }

    /**
     * {@inheritDoc}
     */
    public function removeReservations(\Doctrine\Common\Collections\ArrayCollection $reservations)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeReservations', array($reservations));

        return parent::removeReservations($reservations);
    }

    /**
     * {@inheritDoc}
     */
    public function getReservations()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReservations', array());

        return parent::getReservations();
    }

    /**
     * {@inheritDoc}
     */
    public function addReservation($reservation)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addReservation', array($reservation));

        return parent::addReservation($reservation);
    }

    /**
     * {@inheritDoc}
     */
    public function getLine()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLine', array());

        return parent::getLine();
    }

    /**
     * {@inheritDoc}
     */
    public function setLine($Line)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLine', array($Line));

        return parent::setLine($Line);
    }

    /**
     * {@inheritDoc}
     */
    public function getCooperative()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCooperative', array());

        return parent::getCooperative();
    }

    /**
     * {@inheritDoc}
     */
    public function setCooperative($Cooperative)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCooperative', array($Cooperative));

        return parent::setCooperative($Cooperative);
    }

    /**
     * {@inheritDoc}
     */
    public function getSeatAvailable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSeatAvailable', array());

        return parent::getSeatAvailable();
    }

}