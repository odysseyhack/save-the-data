<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Service\EvidenceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EvidenceController extends AbstractController {

    private $evidenceService;
    private $filesystem;

    public function __construct(EvidenceService $evidenceService)
    {
        $this->evidenceService = $evidenceService;
        $this->filesystem = new Filesystem();
    }

    public function createEvidence(Request $request)
    {
        $incidentRepo = $this->getDoctrine()->getRepository(Incident::class);
        /**
         * @var Incident $incident
         */
        $incident = $incidentRepo->findOneBy(['id' => $request->query->get('incidentId')]);

        if (is_null($incident)) {
            return new JsonResponse(['state' => 'error', 'Incident not found.'], 400);
        }

        $evidence = $this->evidenceService->createEvidence($incident);

        $em = $this->getDoctrine()->getManager();

        $em->persist($evidence);
        $em->flush();

        return new JsonResponse(['state' => 'success', 'name' => $evidence->getName()]);
    }

    public function pictureUpload(Request $request)
    {
        $file = $request->files->get('photo');
        $name = $request->query->get('name');

        if (is_null($name) || is_null($file)) {
            return new JsonResponse(['state' => 'error', 'Name or file not found.'], 400);
        }

        $filename = $file->getClientOriginalName();
        $extension = explode('.', $filename)[1];

//        var_dump($filename);exit;
        $this->filesystem->dumpFile('/var/images/'.$name.$extension, $file);
        return new JsonResponse(['state' => 'success', 'message' => 'File successfully uploaded.']);
    }

}