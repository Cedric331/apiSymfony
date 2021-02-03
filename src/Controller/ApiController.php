<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

      /**
     * @Route("/liste/departement", name="region_departement")
     */
    public function listeRegionParDepartement(Request $request, SerializerInterface $serializer): Response
    {
      $code = $request->query->get('code');
      $apiContent = file_get_contents('https://geo.api.gouv.fr/regions');
      $regions = $serializer->deserialize($apiContent, 'App\Entity\Region[]', 'json');
      $departements = [];

      if ($code == null || $code == 'all') {
         $departementContent = file_get_contents('https://geo.api.gouv.fr/departements');
         $departements = $serializer->decode($departementContent, 'json');
      } else {
         $departementContent = file_get_contents('https://geo.api.gouv.fr/regions/'.$code.'/departements');
         $departements = $serializer->decode($departementContent, 'json');
      }

      return $this->render('api/departement.html.twig', [
         'regions' => $regions,
         'departements' => $departements
      ]);
    }
}
