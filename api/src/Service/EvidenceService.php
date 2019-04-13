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

    /**
     * Create new evidence, can be done by dispatch room
     * @param Incident $incident
     * @return Evidence|null
     */
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


    /**
     * Adds picture to evidence
     * @param string $name
     * @param string $filePath
     * @return void|null
     */
    public function updateEvidence(string $name, string $filePath)
    {
        try {
            $img = new \Imagick($filePath);
        } catch (\ImagickException $e) {
            return;
        }

        $pathArray = explode('/', $filePath);
        $fileName = end($pathArray);

        $allProp = $img->getImageProperties();

        $latitude = $this->getLongLat($allProp['exif:GPSLatitude']);
        $longitude = $this->getLongLat($allProp['exif:GPSLongitude']);

        //TODO: finish this function
        return null;
    }

    /**
     * Gets simple lat/long from a DMS long/lat
     * @param $longOrLat
     * @return float|int|null
     */
    private function getLongLat($longOrLat)
    {
        $elements = explode(", ", $longOrLat);
        if (count($elements) !== 3) {
            return null;
        }

        $degreesArr = explode('/', $elements[0]);
        $degrees = ((int) $degreesArr[0] / (int) $degreesArr[1]);

        $minutesArr = explode('/', $elements[1]);
        $minutes = (float) ((int) $minutesArr[0] / 60 / (int) $minutesArr[1]);

        $secondsArr = explode('/', $elements[2]);
        $seconds = (float) ((int) $secondsArr[0] / 3600 / (int) $secondsArr[1]);

        return $degrees + $minutes + $seconds;
    }

    /**
     * @param string $filename
     * @return array
     */
    public function callClassifier(string $filename)
    {
        $url = 'https://classifier.firesync.online/retrieveImageFeatures?filename='.$filename;

        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);

        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'Accept: application/json'
        ));

        $result = curl_exec($cURL);

        curl_close($cURL);

        return json_decode($result, true);
    }

}
