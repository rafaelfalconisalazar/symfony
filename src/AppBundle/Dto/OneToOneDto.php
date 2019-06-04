<?php


namespace AppBundle\Dto;
use AppBundle\Entity\OneToOne;
use JMS\Serializer\Annotation\Type;

class OneToOneDto
{
    /**
     * @Type("int")
     */
    private $id;

    /**
     * @Type("string")
     */
    private $name;

    /**
     * @Type ("AppBundle\Dto\OneDto")
     */
    private $oneDto;




    public function __construct(OneToOne $oneToOne)
    {
        $this->id=$oneToOne->getId();
        $this->name=$oneToOne->getName();
        $this->oneDto=new OneDto($oneToOne->getOne());
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
     * @return mixed
     */
    public function getOneDto()
    {
        return $this->oneDto;
    }

    /**
     * @param mixed $oneDto
     */
    public function setOneDto($oneDto)
    {
        $this->oneDto = $oneDto;
    }




}