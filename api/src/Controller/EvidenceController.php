<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Service\EvidenceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Flex\Response;

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
        /**
         * @var UploadedFile $file
         */
        $file = $request->files->get('photo');
        $name = bin2hex(openssl_random_pseudo_bytes(10));

        if (is_null($name) || is_null($file)) {
            return new JsonResponse(['state' => 'error', 'message' => 'Name or file not found.'], 400);
        }

        $filename = $file->getClientOriginalName();
        $fileArray = explode('.', $filename);
        $extension = end($fileArray);

        try {
            $filepath = '/var/images/' . $name . '.' . $extension;
            $url = 'https://api.firesync.online/images/'.$name.'.'.$extension;
            $this->filesystem->dumpFile($filepath, file_get_contents($file));
            $result = $this->evidenceService->callClassifier($name.'.'.$extension);
            $finalResult = ['result'=> ['data' => $result, 'url' => $url]];

            return new JsonResponse($finalResult);

        } catch (Exception $e) {
            return new JsonResponse(['state' => 'error', 'message' => 'Name or file not found.'], 400);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function uploadForm(Request $request)
    {
        $name = $request->query->get('name');

        if (is_null($name)) {
            return new JsonResponse(['state' => 'error', 'message' => 'No name given.']);
        }

        return $this->render('file_upload.html.twig', ['name' => $name]);
    }

}