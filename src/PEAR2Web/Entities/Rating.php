<?php

namespace PEAR2Web\Entities;

/** @Entity @Table(name="rating") */
class Rating
{
    /**
     * @Id @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $_id;

    /** @Column(name="liked", type="boolean") */
    private $_liked;

    /** @Column(name="createdate", type="datetime", length=255) */
    private $_date;

    /** @Column(name="ip_address", type="string", length=15) */
    private $_ipAddress;

    public function getId()
    {
        return $this->_id;
    }

    public function getLiked()
    {
        return $this->_liked;
    }

    public function setLiked($liked)
    {
        $this->_liked = ($liked) ? true : false;
    }

    public function getDate()
    {
        return $this->_date;
    }

    public function setDate(DateTime $date)
    {
        $this->_date = $date;
    }

    public function getIpAddress()
    {
        return $this->_ipAddress;
    }

    public function setIpAddress($ipAddress)
    {
        $this->_ipAddress = $ipAddress;
    }
}
