<?php

namespace AppBundle\Controller;

use AppBundle\Dto\OneDto;
use AppBundle\Entity\One;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializerBuilder;
use Nelmio\ApiDocBundle\Annotation\Model;


/**
 *
 * @Rest\Route("api/v1/one")
 */
class OneController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("")
     *
     * @SWG\Tag(name="one")
     * @SWG\Response(
     *     response=200,
     *     description="Return all one entity",
     *    @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=OneDto::class))
     *     )
     * )
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
     *
     * @SWG\Tag(name="one")
     * @SWG\Response(
     *     response=200,
     *     description="Return  one entity by id",
     *    @SWG\Schema(
     *         @SWG\Items(ref=@Model(type=OneDto::class))
     *     )
     * )
     */
    public function listOneById($id)
    {
        $one = $this->getDoctrine()->getRepository('AppBundle:One')->find($id);
        if ($one == null) {
            return new View("no one entity found", Response::HTTP_NOT_FOUND);
        } else {
            $oneDto = new OneDto($one);
            return $oneDto;
        }

    }

    /**
     * @Rest\Post("")
     * @SWG\Tag(name="one")
     * @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              @Model(type=OneDto::class)
     *          )
     *
     *      )
     * @SWG\Response(
     *     response=201,
     *     description="Return one create ",
     * )
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
     * @Rest\Put("/{id}")
     * @SWG\Tag(name="one")
     * @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              @Model(type=OneDto::class)
     *          )
     *
     *      )
     * @SWG\Response(
     *     response=201,
     *     description="Return one create ",
     * )
     */
    public function editOne(Request $request,$id)
    {
        $serializer = SerializerBuilder::create()->build();

        try {
            $oneDto = $serializer->deserialize($request->getContent(), 'AppBundle\Dto\OneDto', 'json');
            $one = $this->getDoctrine()->getRepository('AppBundle\Entity\One')->find($id);
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
