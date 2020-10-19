<?php

namespace App\Controller;

use App\Entity\Spot;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class SpotController extends AbstractController
{
    /**
     * @Route("/spot", name="spot")
     */
    public function index()
    {
        return $this->render('spot/index.html.twig', [
            'controller_name' => 'SpotController',
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     * @Route ("/choucroute", name="choucroute", methods={"GET"})
     */
    public function getAvailableSpotsJson(Request $request, EntityManagerInterface $entityManager)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $spotRepository = $entityManager->getRepository(Spot::class);

        $spots = $spotRepository->spotTest(1);
        $jsonContent = $serializer->serialize($spots, 'json',
            [AbstractNormalizer::IGNORED_ATTRIBUTES => ['events','town']]);
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }
}
