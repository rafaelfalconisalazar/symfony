<?php


namespace AppBundle\Dto;
use JMS\Serializer\Annotation\Type;
use AppBundle\Entity\One;

class OneDto
{
    /**
     * @Type("string")
     */
    private $name;

    /**
     * @Type("int")
     */
    private $id;



    public function __construct(One $one){
        $this->name=$one->getName();
        $this->id=$one->getId();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }






}