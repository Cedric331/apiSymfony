<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/liste", name="liste")
     */
    public function listeRegion(SerializerInterface $serializer): Response
    {
      $apiContent = file_get_contents('https://geo.api.gouv.fr/regions');
      // $array = $serializer->decode($apiContent, 'json');
      // $regions = $serializer->denormalize($array, 'App\Entity\Region[]');
      $regions = $serializer->deserialize($apiContent, 'App\Entity\Region[]', 'json');

      return $this->render('api/index.html.twig', [
         'regions' => $regions
      ]);
    }
}
