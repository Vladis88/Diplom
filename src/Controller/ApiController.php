<?php

namespace App\Controller;

use App\Entity\CarGeneration;
use App\Entity\CarMark;
use App\Entity\CarModel;
use App\Entity\CarPost;
use App\Form\Filter\SimpleFilterForm;
use App\Model\Filter\SimpleFilterModel;
use App\Repository\Filter\SimpleFilterRepository;
use App\Serializer\CarPostSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class TestController
 * @package App\Controller
 */
class ApiController extends AbstractController
{
    /**
     * @var CarPostSerializer
     */
    private $carPostSerializer;

    /**
     * @var SimpleFilterRepository
     */
    private $simpleFilterRepository;

    private $carPostAttr = [
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
    ];

    /**
     * TestController constructor.
     * @param CarPostSerializer $carPostSerializer
     * @param SimpleFilterRepository $filterRepository
     */
    public function __construct(CarPostSerializer $carPostSerializer, SimpleFilterRepository $filterRepository)
    {
        $this->carPostSerializer = $carPostSerializer;
        $this->simpleFilterRepository = $filterRepository;
    }

    /**
     * @Route(
     *     "/cars"
     * )
     * @throws ExceptionInterface
     */
    public function showAll()
    {
        /** @var CarPost[] $carPosts */
        $carPosts = $this
            ->getDoctrine()
            ->getRepository(CarPost::class)->findBy(
            [],
            ['createdAtInSystem' => 'DESC'],
            10
        );
        $response = new JsonResponse(
            $this
                ->carPostSerializer
                ->getSerializer()
                ->normalize($carPosts, null, $this->carPostAttr)
        );
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route(
     *     "/get-marks"
     * )
     *
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function getMarks(): JsonResponse
    {
        $marks = $this->getDoctrine()->getRepository(CarMark::class)->findAll();

        $response = new JsonResponse($this->carPostSerializer->getSerializer()->normalize($marks, null, [
            'attributes' => [
                'id',
                'name'
            ]
        ]));

        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route(
     *     "/get-models/{markId}",
     *     requirements={"markId"="\d+"}
     * )
     *
     * @param int $markId
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function getModels(int $markId): JsonResponse
    {
        $models = $this
            ->getDoctrine()
            ->getRepository(CarModel::class)
            ->findBy([
            'mark' => $this
                ->getDoctrine()
                ->getRepository(CarMark::class)
                ->find($markId)
        ]);
        $response = new JsonResponse(
            $this
                ->carPostSerializer
                ->getSerializer()
                ->normalize($models, null, [
            'attributes' => [
                'id',
                'name'
            ]
        ]));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route(
     *     "/get-generations/{modelId}",
     *     requirements={"modelId"="\d+"}
     * )
     *
     * @param int $modelId
     *
     * @return JsonResponse
     *
     * @throws ExceptionInterface
     */
    public function getGenerations(int $modelId): JsonResponse
    {
        $generations = $this->getDoctrine()->getRepository(CarGeneration::class)->findBy([
            'model' => $this->getDoctrine()->getRepository(CarModel::class)->find($modelId)
        ]);

        $response = new JsonResponse($this->carPostSerializer->getSerializer()->normalize($generations, null, [
            'attributes' => [
                'id',
                'name',
                'fromYear',
                'toYear'
            ]
        ]));

        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route(
     *     "/filter"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ExceptionInterface
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function filter(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $filterModel = new SimpleFilterModel();
        $form = $this->createForm(SimpleFilterForm::class, $filterModel);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $filterModel = $form->getData();

            $carPosts = $this->simpleFilterRepository->filter($filterModel);

            $response = new JsonResponse(
                $this
                    ->carPostSerializer
                    ->getSerializer()
                    ->normalize($carPosts, null, $this->carPostAttr));
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

        return new JsonResponse([], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/filter-count"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ExceptionInterface
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function filterCount(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $filterModel = new SimpleFilterModel();
        $form = $this->createForm(SimpleFilterForm::class, $filterModel);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $filterModel = $form->getData();

            $count = $this->simpleFilterRepository->filter($filterModel, true);

            $response = new JsonResponse(['count' => (int) $count]);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

        return new JsonResponse([], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(
     *     "/api/get-user"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ExceptionInterface
     */
    public function user(Request $request): JsonResponse
    {
        return new JsonResponse($this->carPostSerializer->getSerializer()->normalize($this->getUser(), null, [
            'attributes' => [
                'id',
                'username',
                'email'
            ]
        ]));
    }
}
