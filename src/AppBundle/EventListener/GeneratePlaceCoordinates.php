<?php
namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Place;
use Ivory\GoogleMap\Service\Geocoder\GeocoderService;
use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;
use Ivory\GoogleMap\Service\Geocoder\Request\GeocoderAddressRequest;

class GeneratePlaceCoordinates
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Place) {
            return;
        }

        $geocoder = new GeocoderService(
            new Client(),
            new GuzzleMessageFactory(),
            SerializerBuilder::create()
        );

        $street = $entity->getStreet();
        $zip_code = $entity->getZipCode();
        $city = $entity->getCity();
        $country = $entity->getCountry();

        $request = new GeocoderAddressRequest($street . ', ' . $zip_code . ', ' . $city . ', ' . $country);
        $response = $geocoder->geocode($request);

        $results = $response->getResults();

        if ($results) {
            $longitude = $results[0]->getGeometry()->getLocation()->getLongitude();
            $latitude = $results[0]->getGeometry()->getLocation()->getLatitude();

            $entity->setLongitude($longitude);
            $entity->setLatitude($latitude);
        }
    }
}
