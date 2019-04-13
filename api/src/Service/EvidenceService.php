<?php

namespace App\Service;

use App\Entity\Evidence;
use App\Entity\Incident;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EvidenceService {

    private $serializer;
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function createEvidence(Incident $incident)
    {
        try {
            $evidenceName =  bin2hex(openssl_random_pseudo_bytes(10));

            $evidence = new Evidence();
            $evidence->setIncident($incident);
            $evidence->setName($evidenceName);

            return $evidence;
        } catch (\Exception $e) {
            $this->logger->error("could not create random string: " . $e->getMessage());
            return null;
        }
    }

}
