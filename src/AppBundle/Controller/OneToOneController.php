<?php

namespace AppBundle\Controller;


use AppBundle\Entity\OneToOne;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Dto\OneToOneDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializerBuilder;

/**
 *
 * @Rest\Route("api/v1/onetoone")
 */
class OneToOneController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("")
     */
    public function listAllOneToOne()
    {
        $oneToOnes = $this->getDoctrine()->getRepository('AppBundle:OneToOne')->findAll();
        $onetoOnesDto = array();
        foreach ($oneToOnes as $onetoOne) {
            $onetoOneDto = new OneToOneDto($onetoOne);

            array_push($onetoOnesDto, $onetoOneDto);
        }
        return $onetoOnesDto;
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function listByIdOneToOne($id)
    {
        $oneToOne = $this->getDoctrine()->getRepository('AppBundle:OneToOne')->find($id);
        $onetoOneDto = new OneToOneDto($oneToOne);
        return $onetoOneDto;
    }

    /**
     * @Rest\Post("")
     */
    public function createOneToOne(Request $request)
    {
        $serializer = SerializerBuilder::create()->build();

        try {
            $oneToOneDto = $serializer->deserialize($request->getContent(), 'AppBundle\Dto\OneToOneDto', 'json');
            $oneToOne = new OneToOne();
            $oneToOne->setName($oneToOneDto->getName());
            $oneToOneDtoOne = $oneToOneDto->getOneDto();
            $one = $this->getDoctrine()->getRepository('AppBundle:One')->find($oneToOneDtoOne->getId());
            $oneToOne->setOne($one);
            $em = $this->getDoctrine()->getManager();
            $em->persist($oneToOne);
            $em->flush();
            return new View("one created", Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new View($e, Response::HTTP_BAD_REQUEST);
        }
    }


}
