<?php

namespace AppBundle\Controller;

use AppBundle\Dto\OneDto;
use AppBundle\Entity\One;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializerBuilder;


/**
 *
 * @Rest\Route("api/v1/one")
 */
class OneController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("")
     */
    public function listAllOne()
    {
        $ones = $this->getDoctrine()->getRepository('AppBundle:One')->findAll();
        $onesDto = array();
        foreach ($ones as $one) {
            $oneDto = new OneDto($one);
            array_push($onesDto, $oneDto);
        }
        return $onesDto;
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function listOneById($id)
    {
        $one = $this->getDoctrine()->getRepository('AppBundle:One')->find($id);
        $oneDto = new OneDto($one);
        return $oneDto;
    }

    /**
     * @Rest\Post("")
     */
    public function createOne(Request $request)
    {
        $serializer = SerializerBuilder::create()->build();

        try {
            $oneDto = $serializer->deserialize($request->getContent(), 'AppBundle\Dto\OneDto', 'json');
            $one = new One();
            $one->setName($oneDto->getName());
            $em = $this->getDoctrine()->getManager();
            $em->persist($one);
            $em->flush();
            return new View("one created", Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new View($e, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("")
     */
    public function editOne(Request $request)
    {
        $serializer = SerializerBuilder::create()->build();

        try {
            $oneDto = $serializer->deserialize($request->getContent(), 'AppBundle\Dto\OneDto', 'json');
            $one = $this->getDoctrine()->getRepository('AppBundle\Entity\One')->find($oneDto->getId());
            if ($one == null) {
                return new View("One not found", Response::HTTP_NOT_FOUND);
            } else {
                if ($oneDto->getName() !== null) {
                    $one->setName($oneDto->getName());
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($one);
                $em->flush();
                return new View("one update", Response::HTTP_CREATED);
            }

        } catch (\Exception $e) {
            return new View($e, Response::HTTP_BAD_REQUEST);
        }
    }


}
