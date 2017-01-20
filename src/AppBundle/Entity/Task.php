<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Task
 */
class Task
{
    /**
     * @var string
     * 
     * 
     */
    private $name;

    /**
     * @var string
     * 
     */
    private $descryption;

    /**
     * @var \DateTime
     * 
     * 
     */
    private $startDate;

    /**
     * @var \DateTime
     * 
     * 
     */
    private $endDate;

    /**
     * @var integer
     * 
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     * @return Task
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set descryption
     *
     * @param string $descryption
     * @return Task
     */
    public function setDescryption($descryption)
    {
        $this->descryption = $descryption;

        return $this;
    }

    /**
     * Get descryption
     *
     * @return string 
     */
    public function getDescryption()
    {
        return $this->descryption;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Task
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Task
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
