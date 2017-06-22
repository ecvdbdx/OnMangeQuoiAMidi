<?php
namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Place;
use Cocur\Slugify\Slugify;


class GeneratePlaceImage
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Place || $entity->getId()) {
            return;
        }
        $slugify = new Slugify();
        $id = uniqid($slugify->slugify($entity->getName()).'_');

        $path = __DIR__ . '/../../../web/images/places/';

        if (!file_exists($path)) {
          mkdir($path, 0777, true);
        }

        $dest = $path.$id.'.png';
        $src = 'http://placeimg.com/500/200/arch/grayscale?random=1';

        if(copy($src, $dest)){
          $entity->setImage($id.'.png');
        }
    }
}
