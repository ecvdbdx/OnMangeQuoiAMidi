<?php
namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\EntityInfos;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class updateModifierUser
{
    private $token;

    public function __construct(TokenStorage $token){
        $this->token = $token;
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Place) {
            return;
        }

        $entityManager = $args->getEntityManager();
        $id = $this->token->getUser()->getId();
        $entity->setModifierUserId($id);
    }
}