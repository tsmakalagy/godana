<?php

namespace DoctrineORMModule\Proxy\__CG__\Godana\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class City extends \Godana\Entity\City implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'id', 'countryCode', 'cityName', 'cityAccented', 'region', 'population', 'latitude', 'longitude');
        }

        return array('__isInitialized__', 'id', 'countryCode', 'cityName', 'cityAccented', 'region', 'population', 'latitude', 'longitude');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (City $proxy) {
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
    public function getCountryCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCountryCode', array());

        return parent::getCountryCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setCountryCode($countryCode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCountryCode', array($countryCode));

        return parent::setCountryCode($countryCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getCityName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCityName', array());

        return parent::getCityName();
    }

    /**
     * {@inheritDoc}
     */
    public function setCityName($cityName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCityName', array($cityName));

        return parent::setCityName($cityName);
    }

    /**
     * {@inheritDoc}
     */
    public function getCityAccented()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCityAccented', array());

        return parent::getCityAccented();
    }

    /**
     * {@inheritDoc}
     */
    public function setCityAccented($cityAccented)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCityAccented', array($cityAccented));

        return parent::setCityAccented($cityAccented);
    }

    /**
     * {@inheritDoc}
     */
    public function getRegion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRegion', array());

        return parent::getRegion();
    }

    /**
     * {@inheritDoc}
     */
    public function setRegion($region)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRegion', array($region));

        return parent::setRegion($region);
    }

    /**
     * {@inheritDoc}
     */
    public function getPopulation()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPopulation', array());

        return parent::getPopulation();
    }

    /**
     * {@inheritDoc}
     */
    public function setPopulation($population)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPopulation', array($population));

        return parent::setPopulation($population);
    }

    /**
     * {@inheritDoc}
     */
    public function getLatitude()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLatitude', array());

        return parent::getLatitude();
    }

    /**
     * {@inheritDoc}
     */
    public function setLatitude($latitude)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLatitude', array($latitude));

        return parent::setLatitude($latitude);
    }

    /**
     * {@inheritDoc}
     */
    public function getLongitude()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLongitude', array());

        return parent::getLongitude();
    }

    /**
     * {@inheritDoc}
     */
    public function setLongitude($longitude)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLongitude', array($longitude));

        return parent::setLongitude($longitude);
    }

}
