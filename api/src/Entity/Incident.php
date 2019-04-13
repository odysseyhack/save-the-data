<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Incident
 * Symbolizes 1 fire where multiple callers can be connected to
 * @ORM\Entity(repositoryClass="App\Repository\IncidentRepository")
 */
class Incident {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     */
    private $street;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $house_number;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $house_number_addition;

    /**
     * @ORM\Column(type="datetime")
     */
    private $first_call_time;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_call_time;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street): void
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getHouseNumber()
    {
        return $this->house_number;
    }

    /**
     * @param mixed $house_number
     */
    public function setHouseNumber($house_number): void
    {
        $this->house_number = $house_number;
    }

    /**
     * @return mixed
     */
    public function getHouseNumberAddition()
    {
        return $this->house_number_addition;
    }

    /**
     * @param mixed $house_number_addition
     */
    public function setHouseNumberAddition($house_number_addition): void
    {
        $this->house_number_addition = $house_number_addition;
    }

    /**
     * @return mixed
     */
    public function getFirstCallTime()
    {
        return $this->first_call_time;
    }

    /**
     * @param mixed $first_call_time
     */
    public function setFirstCallTime($first_call_time): void
    {
        $this->first_call_time = $first_call_time;
    }

    /**
     * @return mixed
     */
    public function getLastCallTime()
    {
        return $this->last_call_time;
    }

    /**
     * @param mixed $last_call_time
     */
    public function setLastCallTime($last_call_time): void
    {
        $this->last_call_time = $last_call_time;
    }

}