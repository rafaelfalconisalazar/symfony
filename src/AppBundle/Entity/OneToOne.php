<?php

namespace AppBundle\Entity;

/**
 * OneToOne
 */
class OneToOne
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var One
     */
    private $one;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return OneToOne
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
     * @return One
     */
    public function getOne()
    {
        return $this->one;
    }

    /**
     * @param One $one
     */
    public function setOne($one)
    {
        $this->one = $one;
    }


}

