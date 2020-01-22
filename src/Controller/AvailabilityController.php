<?php

namespace App\Controller;

use App\Entity\Availability;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AvailabilityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class AvailabilityController extends AbstractController
{
    
    /**
     * @Route("/papi/availability", name="api_availability_index", methods={"GET"})
     */
    public function index(AvailabilityRepository $availabilityRepository, SerializerInterface $serializer)
    {
        $availabilitys = $availabilityRepository->findOneByIdJoinedToCategory();

        return $this->json($availabilitys, 200, [], ['groups' => 'post:read']);;
    }

    
}
