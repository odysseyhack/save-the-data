<?php

namespace App\Service;

use App\Entity\Incident;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class IncidentService {

    private $serializer;

    public function __construct()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function getIncidentFromReq(Request $request)
    {
        $incident = $this->getRequestParameters($request);

        if (is_null($incident)) return null;

        $newIncident = new Incident();
        $newIncident->setCity($incident['city']);
        $newIncident->setStreet($incident['street']);
        $newIncident->setHouseNumber($incident['house_number']);
        $newIncident->setHouseNumberAddition($incident['house_number_addition']);
        $newIncident->setFirstCallTime(new \DateTime('now'));
        $newIncident->setLastCallTime(new \DateTime('now'));

        return $newIncident;
    }

    private function getRequestParameters(Request $request) : array
    {
        $city = $request->request->get('city');
        $street = $request->request->get('street');
        $houseNumber = (int) $request->request->get('houseNumber');
        $houseNumberAddition = $request->request->get('houseNumberAddition');

        if (!is_string($city) || !is_string($street)) {
            return null;
        }

        return [
            'city' => $city,
            'street' => $street,
            'house_number' => (is_int($houseNumber) ? $houseNumber : null),
            'house_number_addition' => (is_string($houseNumberAddition) &&
                strlen($houseNumberAddition) === 1 ? $houseNumberAddition : null),
        ];
    }


    public function getIncidentJson(Incident $incident)
    {
        $jsonContent = $this->serializer->serialize($incident, 'json');

        return $jsonContent;
    }

}