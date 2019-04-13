<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Service\IncidentService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class IncidentController extends AbstractController {

    private $logger;
    private $incidentService;

    public function __construct(LoggerInterface $logger, IncidentService $incidentService)
    {
        $this->logger = $logger;
        $this->incidentService = $incidentService;
    }

    public function createIncident(Request $request)
    {
        $incident = $this->incidentService->getIncidentFromReq($request);

        if (is_null($incident)) {
            return new JsonResponse(['state' => 'error', 'message' => 'Invalid incident data given.'], 400);
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($incident);
        $em->flush();

        return new JsonResponse($this->incidentService->getIncidentJson($incident));
    }


}