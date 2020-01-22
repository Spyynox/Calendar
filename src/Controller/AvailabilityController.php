<?php

namespace App\Controller;

use App\Entity\Availability;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AvailabilityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class AvailabilityController extends AbstractController
{

    private $availabilityRepository;

    public function __construct(AvailabilityRepository $availabilityRepository)
    {
        $this->availabilityRepository = $availabilityRepository;
    }
    
    /**
     * @Route("/papi/availability", name="api_availability_index", methods={"GET"})
     */
    public function index(AvailabilityRepository $availabilityRepository, SerializerInterface $serializer)
    {
        $availabilitys = $availabilityRepository->findOneByIdJoinedToCategory();

        return $this->json($availabilitys, 200, [], ['groups' => 'post:read']);
    }


    /**
     * @Route("/papi/availability", name="api_availability_store", methods={"POST"})
     */
    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $jsonRecu = $request->getContent();

        try {
            $availability = $serializer->deserialize($jsonRecu, Availability::class, 'json');

            $errors = $validator->validate($availability);

            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }

            $em->persist($availability);
            $em->flush();

            return $this->json($availability, 201, [], ['groups' => 'post:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @Route("/papi/availability/{id}", name="update_availability", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $availability = $this->availabilityRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['date']) ? true : $availability->setDate(new \DateTime($data['date']));

        $updatedAvailability = $this->availabilityRepository->updateAvailability($availability);

        return new JsonResponse($updatedAvailability->toArray(), Response::HTTP_OK);
    }


    /**
     * @Route("/papi/availability/{id}", name="delete_availability", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $availability = $this->availabilityRepository->findOneBy(['id' => $id]);

        $this->availabilityRepository->removeAvailability($availability);

        return new JsonResponse(['status' => 'availability deleted'], Response::HTTP_NO_CONTENT);
    }

    
}
