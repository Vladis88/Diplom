<?php

namespace App\Controller;

use App\Entity\CarPost;
use App\Serializer\CarPostSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CustomController extends AbstractController
{
    /**
     * @Route(
     *     "/custom/{max}",
     *     name="custom_route"
     * )
     * @param int $max
     */
    public function index(int $max)
    {
        dump($max);
        dump('Hello custom route');exit();
    }

    /**
     * @Route(
     *     "/list"
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        $carPosts = $this->getDoctrine()->getRepository(CarPost::class)->findAll();

        return $this->render('avto-list.html.twig', compact('carPosts'));
    }

    /**
     * @Route(
     *     "/api/list"
     * )
     *
     * @param Request $request
     * @param CarPostSerializer $serializer
     *
     * @return JsonResponse
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function listJson(Request $request, CarPostSerializer $serializer): JsonResponse
    {
        $carPosts = $this->getDoctrine()->getRepository(CarPost::class)->findAll();

        return new JsonResponse($serializer->getSerializer()->normalize($carPosts, null, [
            'attributes' => [
                'id',
                'title',
                'description',
                'sellerName',
                'sellerPhones',
                'link',
                'previewImage',
                'images',
                'carInfo' => [
                    'id',
                    'mark' => [
                        'id',
                        'name'
                    ],
                    'model' => [
                        'id',
                        'name'
                    ],
                    'year',
                    'generation' => [
                        'id',
                        'name',
                        'fromYear',
                        'toYear'
                    ],
                    'bodyType' => [
                        'id',
                        'name'
                    ],
                    'modification',
                    'shape' => [
                        'id',
                        'name'
                    ],
                    'price' => [
                        'id',
                        'byn',
                        'usd'
                    ],
                    'mileage',
                    'mileageMeasure' => [
                        'id',
                        'name'
                    ],
                    'engine' => [
                        'id',
                        'type' => [
                            'id',
                            'name'
                        ],
                        'engineCapacity',
                        'engineCapacityHint',
                        'hybrid',
                        'gasEquipment',
                        'gasEquipmentType' => [
                            'id',
                            'name'
                        ],
                        'powerReserve',
                        'powerReserveHint'
                    ],
                    'transmission' => [
                        'id',
                        'name'
                    ],
                    'driveType' => [
                        'id',
                        'name'
                    ],
                    'color' => [
                        'id',
                        'name'
                    ]
                ]
            ]
        ]));
    }
}
