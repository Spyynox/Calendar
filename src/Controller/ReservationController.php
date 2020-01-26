<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    private $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @Route("/apis/reservation", name="api_reservation_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository, SerializerInterface $serializer)
    {
        $reservations = $reservationRepository->findAll();

        return $this->json($reservations, 200, [], ['groups' => 'reservation']);
    }

    /**
     * @Route("/apis/reservation/{id}", name="get_one_reservation", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $responder = $this->responder;

        $reservation = $this->reservationRepository->findOneById(['id' => $id]);

        $data = [
            'id' => $reservation->getId(),
            'doctor' => $reservation->getDoctor(),
            'client' => $reservation->getClient(),
        ];

        

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
